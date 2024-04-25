<?php

namespace App\Livewire\FoodListing;

use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use App\Models\Application;
use App\Models\FoodListing;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\DB;
use App\Mail\FoodPostedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * This class manages the creation of food listings.
 * It handles form validation, image uploads, storing listing details in the database,
 * updating location coordinates, sending email notifications to users,
 * and rendering the create food listing view.
 */
class CreateFoodListing extends Component
{

    use WithFileUploads;
    // Form field properties
    public $name;
    public $ingredients;
    public $quantity;
    public $allergen;
    public $description;
    public $status;
    public $category_id;

    // Location properties
    public $latitude;
    public $longitude;
    public $searchName;
    public $food_listing_id;

    // Other properties
    public $images = [];
    public $imageUrls = [];
    public $categories;
    public $subject;
    public $email_body;

    protected $listeners = [
        "updateLocationCoordinates" => 'setLocation',
        'inputValueUpdated' => 'updateInputValue',
    ];
    protected $rules = [
        'name' => 'required|string|max:200',
        'ingredients' => 'required|string',
        'quantity' => 'required|numeric|min:1|max:255',
        'allergen' => 'required|string',
        'description' => 'required|string|max:1000',
        'status' => 'required|boolean',
        'category_id' => 'required|exists:categories,id',
        'images.*' => 'image|max:1024',

    ];

    public function render()
    {
        return view('livewire.food-listing.create-food-listing')
            ->layout('livewire.app.app-layout');
    }

    /**
     * Initialize the component by fetching all categories.
     *
     * @return void
     */
    public function mount()
    {

        $this->categories = Category::all();
    }

    /**
     * Uploads an image and returns the file name.
     *
     * @param  \Illuminate\Http\UploadedFile  $image The image to upload.
     * @return string The file name of the uploaded image.
     */
    public function uploadImage($image)
    {
        $fileName = 'food_images/' . Str::random(40) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public', $fileName);
        return $fileName;
    }

    /**
     * Stores the food listing details in the database.
     * Validates the input, creates a new food listing record,
     * saves location coordinates, sends email notifications, and resets the form.
     *
     * @return void
     */
    public function store()
    {
        // Validate form input
        $this->validate();

        // Check if user is logged in
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to create a listing.');
            return redirect()->route('login');
        }
        $foodListing = new FoodListing();


        // Create instance of new food listing 

        DB::transaction(function () use ($foodListing) {
            $foodListing->name = $this->name;
            $foodListing->ingredients = $this->ingredients;
            $foodListing->quantity = $this->quantity;
            $foodListing->allergen = $this->allergen;
            $foodListing->description = $this->description;
            $foodListing->status = $this->status;
            $foodListing->category_id = $this->category_id;
            $foodListing->user_id = Auth::id();

            // Upload and save images
            if (!empty($this->images)) {
                $imagePaths = [];
                foreach ($this->images as $image) {
                    $fileName = $this->uploadImage($image);
                    array_push($imagePaths, $fileName);
                }
                $foodListing->photo_url = json_encode($imagePaths);
            }
            // Save the food listing
            $foodListing->save();

            // Submit location coordinates
            $this->submitLocation($foodListing->id, $this->latitude, $this->longitude, $this->searchName);


            $this->sendFoodListingCreatedEmail($foodListing);
        });

        $this->reset('name', 'ingredients', 'quantity', 'allergen', 'description', 'status', 'category_id', 'images', 'latitude', 'longitude', 'searchName');
        $this->dispatch('foodListingCreated');
        session()->flash('success', 'Food listing created successfully.');
    }

    protected function submitLocation($foodListingId, $latitude, $longitude, $searchName = null)
    {
        $foodListing = FoodListing::find($foodListingId);

        if ($foodListing) {
            $location = $foodListing->location()->first();

            if ($location) {
                $location->update([
                    'searchName' => $searchName,
                    'latitude' => $latitude,
                    'longitude' => $longitude,

                ]);
            } else {
                $foodListing->location()->create([
                    'searchName' => $searchName,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]);
            }
            $this->dispatch('locationSaved');
        }
    }

    /**
     * Sets the location coordinates.
     *
     * @param  float  $latitude The latitude coordinate.
     * @param  float  $longitude The longitude coordinate.
     * @param  string  $searchName The name used for searching the location.
     * @return void
     */
    public function setLocation($latitude, $longitude, $searchName)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->searchName = $searchName;
        $this->reset(['latitude', 'longitude', 'searchName']);
    }


    public function sendFoodListingCreatedEmail($foodListing)
    {
        // Fetch eligible users based on the quantity of food available
        $eligibleUsers = $this->eligibility($foodListing->quantity);

        if ($eligibleUsers->isEmpty()) {
            \Log::info('No users with approved applications eligible for new food listing notification.');
            return;  // Exit if no eligible users are found
        }

        // Sending an email to each eligible user
        foreach ($eligibleUsers as $user) {
            $emailSubject = 'New Food Listing: ' . ($foodListing->name ?? 'Unnamed Listing');
            $details = [
                'email' => $user->email,
                'name' => $user->first_name ?? 'Valued User',
                'subject' => $emailSubject,
                'title' => 'A new food listing has been posted!',
                'body' => 'We have uploaded a new food. Please click on the link to reserve: ' . ($foodListing->name ?? 'Unnamed Listing'),
                'url' => url('/dashboard'),
                'footer' => 'Team Food Sharing App',
            ];

            try {
                Mail::to($user->email)->queue(new FoodPostedNotification($details));
            } catch (\Exception $e) {
                \Log::error("Failed to send email to {$user->email}: {$e->getMessage()}");
                continue;
            }
            // Save the email notification to the database
            $notification = new EmailNotification();
            $notification->user_id = $user->id;
            $notification->food_listing_id = $foodListing->id;
            $notification->is_read = false;
            $notification->subject = $emailSubject;
            $notification->email_body = $details['body'];
            $notification->save();
        }
    }

    /**
     * Retrieve a list of eligible users based on their application approval status and family income.
     * 
     * This function fetches users whose applications have been approved and sorts them by their family income in ascending order.
     * It limits the results to the specified quantity, which is useful for allocating limited resources like food.
     * 
     * @param int $quantity The maximum number of users to retrieve.
     * @return \Illuminate\Database\Eloquent\Collection A collection of user models that match the criteria.
     */
    // public function eligiblity($quantity)
    // {
    //     // Fetch users with approved applications, ordered by their family income
    //     $users = User::query()
    //         ->select('users.*')
    //         ->join('applications', 'applications.user_id', '=', 'users.id') // Ensuring we join with applications
    //         ->where('applications.status', '=', 'approved')  // Only include users with approved applications
    //         ->orderBy('applications.family_income', 'asc')  // Order by ascending family income
    //         ->take($quantity)  // Limit the number of users based on the available quantity of food
    //         ->get();

    //     return $users;
    // }

    

// public function eligibility($quantity)
// {
//     // Fetch users whose applications are approved, sorted by the family income of the application.
//     $usersWithApprovedApplications = User::whereHas('application', function ($query) {
//         $query->where('status', 'approved');  // Ensure the application is approved
//     })->with(['application' => function ($query) {
//         $query->where('status', 'approved')->orderBy('family_income', 'asc');  // Load the approved application sorted by income
//     }])->get();

//     // Prepare the collection to store eligible users, ensuring uniqueness by user_id
//     $eligibleUsers = collect();
//     $processedUserIds = [];

//     // Iterate through the users to select those with the lowest family incomes first
//     foreach ($usersWithApprovedApplications as $user) {
//         if (!in_array($user->id, $processedUserIds) && $eligibleUsers->count() < $quantity) {
//             $eligibleUsers->push($user);
//             $processedUserIds[] = $user->id;  // Track the user ID to prevent duplicate entries
//         }
//     }

//     // Handle the scenario where multiple users have the same family income
//     $groupedByIncome = $eligibleUsers->groupBy(function ($user) {
//         return $user->application->family_income;
//     });

//     $finalEligibleUsers = collect();
//     foreach ($groupedByIncome as $income => $users) {
//         if ($users->count() > 1) {
//             // Randomize users with the same income level
//             $finalEligibleUsers = $finalEligibleUsers->merge($users->shuffle());
//         } else {
//             $finalEligibleUsers = $finalEligibleUsers->merge($users);
//         }
//     }

//     // Return the final set of users, ensuring the collection size does not exceed the available quantity of food
//     return $finalEligibleUsers->take($quantity);
// }

//works for approved users

// public function eligibility($quantity)
// {
//     // Fetch users with approved applications, directly joining and ordering by family income
//     $users = User::select('users.*')
//                  ->join('applications', 'users.id', '=', 'applications.user_id')
//                  ->where('applications.status', 'approved')
//                  ->orderBy('applications.family_income', 'asc')
//                  ->with('application')
//                  ->get();

//     $eligibleUsers = collect();
//     $processedUserIds = [];

//     // Filter unique users up to the specified quantity
//     foreach ($users as $user) {
//         if (!in_array($user->id, $processedUserIds) && $eligibleUsers->count() < $quantity) {
//             $eligibleUsers->push($user);
//             $processedUserIds[] = $user->id;  // Ensure each user is only processed once
//         }
//     }

//     // If needed, shuffle users with the same family income
//     // This creates a fair chance for users with the same financial condition
//     $finalEligibleUsers = collect();
//     $lastIncome = null;
//     $sameIncomeUsers = collect();

//     foreach ($eligibleUsers as $user) {
//         if ($lastIncome === $user->application->family_income) {
//             $sameIncomeUsers->push($user);
//         } else {
//             if (!$sameIncomeUsers->isEmpty()) {
//                 $finalEligibleUsers = $finalEligibleUsers->merge($sameIncomeUsers->shuffle());
//                 $sameIncomeUsers = collect([$user]);
//             } else {
//                 $finalEligibleUsers->push($user);
//             }
//             $lastIncome = $user->application->family_income;
//         }
//     }

//     if (!$sameIncomeUsers->isEmpty()) {
//         $finalEligibleUsers = $finalEligibleUsers->merge($sameIncomeUsers->shuffle());
//     }

//     return $finalEligibleUsers->take($quantity);
// }

//works for income 
// public function eligibility($quantity)
// {
//     // Fetch users with approved applications, directly joining and ordering by family income
//     $users = User::select('users.*')
//                  ->join('applications', 'users.id', '=', 'applications.user_id')
//                  ->where('applications.status', 'approved')
//                  ->orderBy('applications.family_income', 'asc')
//                  ->with('application')
//                  ->get();

//     $eligibleUsers = collect();
//     $processedUserIds = [];

//     // Filter unique users up to the specified quantity
//     foreach ($users as $user) {
//         if (!in_array($user->id, $processedUserIds) && $eligibleUsers->count() < $quantity) {
//             $eligibleUsers->push($user);
//             $processedUserIds[] = $user->id;  // Ensure each user is only processed once
//         }
//     }

//     // If needed, shuffle users with the same family income
//     // This creates a fair chance for users with the same financial condition
//     $finalEligibleUsers = collect();
//     $lastIncome = null;
//     $sameIncomeUsers = collect();

//     foreach ($eligibleUsers as $user) {
//         if ($lastIncome === $user->application->family_income) {
//             $sameIncomeUsers->push($user);
//         } else {
//             if (!$sameIncomeUsers->isEmpty()) {
//                 $finalEligibleUsers = $finalEligibleUsers->merge($sameIncomeUsers->shuffle());
//                 $sameIncomeUsers = collect([$user]);
//             } else {
//                 $finalEligibleUsers->push($user);
//             }
//             $lastIncome = $user->application->family_income;
//         }
//     }

//     if (!$sameIncomeUsers->isEmpty()) {
//         $finalEligibleUsers = $finalEligibleUsers->merge($sameIncomeUsers->shuffle());
//     }

//     return $finalEligibleUsers->take($quantity);
// }

public function eligibility($quantity)
{
    // Directly fetch users with approved applications, ensuring we sort by family income.
    $users = User::select('users.id', 'users.email', 'applications.family_income')
                 ->join('applications', 'users.id', '=', 'applications.user_id')
                 ->where('applications.status', '=', 'approved')
                 ->orderBy('applications.family_income', 'asc')
                 ->distinct()
                 ->take($quantity)
                 ->with('application')
                 ->get();

    // Prepare to handle users with the same family income
    $lastIncome = null;
    $usersWithSameIncome = collect();
    $finalEligibleUsers = collect();

    // Iterate through the users and handle same income scenarios
    foreach ($users as $user) {
        if ($lastIncome === $user->application->family_income) {
            $usersWithSameIncome->push($user);
        } else {
            if (!$usersWithSameIncome->isEmpty()) {
                // Shuffle to ensure fairness among same income level users
                $finalEligibleUsers = $finalEligibleUsers->merge($usersWithSameIncome->shuffle());
                $usersWithSameIncome = collect([$user]);
            } else {
                $finalEligibleUsers->push($user);
            }
            $lastIncome = $user->application->family_income;
        }
    }

    // Shuffle the last income group if necessary
    if (!$usersWithSameIncome->isEmpty()) {
        $finalEligibleUsers = $finalEligibleUsers->merge($usersWithSameIncome->shuffle());
    }

    // Return the final collection of eligible users, limited to the quantity specified
    return $finalEligibleUsers->take($quantity);
}

    /**
     * Update the value of a specific input field.
     * 
     * This function assigns new values to properties based on the input field specified by $inputId.
     * The properties that can be updated are: allergen, name, ingredients, and description.
     * 
     * @param string $inputId The ID of the input field whose value is to be updated.
     * @param mixed $value The new value to assign to the input field.
     */
    public function updateInputValue($inputId, $value)
    {
        if ($inputId === 'allergen-input') {
            $this->allergen = $value;
        } elseif ($inputId === 'name-input') {
            $this->name = $value;
        } elseif ($inputId === 'ingredients-input') {
            $this->ingredients = $value;
        } elseif ($inputId === 'description-input') {
            $this->description = $value;
        }
    }
}
