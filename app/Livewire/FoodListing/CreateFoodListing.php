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
            $this->emailNotification($foodListing);
        });

        $this->reset('name', 'ingredients', 'quantity', 'allergen', 'description', 
        'status', 'category_id', 'images', 'latitude', 'longitude', 'searchName');
        session()->flash('success', 'Food listing created successfully.');
        $this->dispatch('foodListingCreated');
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


    /**
     * Dispatches email notifications to users eligible to receive information about a newly created food listing.
     *
     * Initially, this method identifies the list of eligible users by utilising the eligibility method,
     * which filters users based on their application status and the availability of the food.
     * If no users qualify, the method logs this event and terminates early to prevent unnecessary processing.
     * For each eligible user, an email is meticulously crafted and queued for dispatch. The email includes personalised details such as the user's name
     * and a link to view the listing. Should there be a failure in the email dispatch process, an error is logged for future troubleshooting.
     * Notifications that are successfully sent are then recorded in the database, documenting details about the recipient and the specific listing,
     * thereby ensuring traceability and facilitating future analyses of user engagement.
     */
    public function emailNotification($foodListing)
    {
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
     * This function queries users whose applications have been approved, sorting them by their family income in ascending order.
     * It handles users with the same family income by shuffling them to ensure a fair distribution when selecting the final list.
     * The results are limited to the specified quantity, making this suitable for situations where resource allocation is constrained.
     * @param int $quantity The maximum number of users to retrieve, useful for controlling resource allocation limits.
     * @return \Illuminate\Database\Eloquent\Collection A collection of user models that meet the criteria, ensuring fairness in selection.
     */
    public function eligibility($quantity)
    {
        // fetch user's who has applicatiob by their family_income and application status approved
        $users = User::select('users.id', 'users.email', 'users.first_name', 'applications.family_income')
            ->join('applications', 'users.id', '=', 'applications.user_id')
            ->where('applications.status', '=', 'approved')
            ->orderBy('applications.family_income', 'asc')
            ->distinct()
            ->take($quantity)
            ->with('application')
            ->get();

        $income = null;
        $equalIncome = collect();
        $eligbleUser = collect();

        // Handle users with the same family income
        foreach ($users as $user) {
            if ($income === $user->application->family_income) {
                $equalIncome->push($user);
            } else {
                if (!$equalIncome->isEmpty()) {
                    $eligbleUser = $eligbleUser->merge($equalIncome->shuffle());
                    $equalIncome = collect([$user]);
                } else {
                    $eligbleUser->push($user);
                }
                $income = $user->application->family_income;
            }
        }

        if (!$equalIncome->isEmpty()) {
            $eligbleUser = $eligbleUser->merge($equalIncome->shuffle());
        }

        //make sure quantity is equal to email nottification
        return $eligbleUser->take($quantity);
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

//Reference https://larapeak.medium.com/upload-files-and-photos-with-laravel-livewire-959a04e8258a