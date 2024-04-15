<?php

namespace App\Livewire\FoodListing;
use App\Models\User;
use Livewire\Component;
use App\Mail\FoodPosted;
use App\Models\Category;
use App\Models\FoodListing;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Livewire\App\AppLayout;
use App\Models\EmailNotification;
use App\Events\FoodListingCreated;
use App\Mail\FoodPostedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CreateFoodListing extends Component
{

    use WithFileUploads;

    public $name, $ingredients, $quantity, $allergen, $description, $status, $category_id;
    public $latitude, $longitude, $searchName, $food_listing_id;
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

    public function mount()
    {
        
        $this->categories = Category::all();
    }

    public function uploadImage($image)
    {
        $fileName = 'food_images/' . Str::random(40) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public', $fileName);
        return $fileName;
    }
    
    public function store()
    {
        $this->validate();

        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to create a listing.');
            return redirect()->route('login'); // Note: Adapt based on Livewire's handling
        }
        $foodListing = new FoodListing();


        DB::transaction(function () use ($foodListing){
            $foodListing->name = $this->name;
            $foodListing->ingredients = $this->ingredients;
            $foodListing->quantity = $this->quantity;
            $foodListing->allergen = $this->allergen;
            $foodListing->description = $this->description;
            $foodListing->status = $this->status;
            $foodListing->category_id = $this->category_id;
            $foodListing->user_id = Auth::id();


            if (!empty($this->images)) {
                $imagePaths = [];
                foreach ($this->images as $image) {
                    $fileName = $this->uploadImage($image);
                    array_push($imagePaths, $fileName);
                }
                $foodListing->photo_url = json_encode($imagePaths);
            }
            $foodListing->save();

        
            $this->submitLocation($foodListing->id, $this->latitude, $this->longitude, $this->searchName);
            
          
                $this->sendFoodListingCreatedEmail($foodListing);
            
        });

        if ($foodListing) {
            $this->sendFoodListingCreatedEmail($foodListing);
        }
        $this->reset('name', 'ingredients', 'quantity', 'allergen', 'description', 'status', 'category_id', 'images', 'latitude', 'longitude', 'searchName');
        $this->dispatch('foodListingCreated');

        session()->flash('success', 'Food listing created successfully.');
    }
    public function render()
    {
        return view('livewire.food-listing.create-food-listing')
            ->layout('livewire.app.app-layout');
    }
    public function testMethod()
    {
        dd('Method called');
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
    public function setLocation($latitude, $longitude, $searchName)
{
    $this->latitude = $latitude;
    $this->longitude = $longitude;
    $this->searchName = $searchName;
    $this->reset(['latitude', 'longitude', 'searchName']);

}

protected function sendFoodListingCreatedEmail($foodListing)
{
    $users = User::all(); // Retrieve all users or a subset as needed.

    foreach ($users as $user) {
        $emailSubject = 'New Food Listing: ' . ($foodListing->name ?? 'Unnamed Listing'); // Ensure there's a default value

        $details = [
            'email' => $user->email,
            'name' => $user->first_name?? 'Valued User', // Include a fallback default name.

            'subject' => $emailSubject,
            'title' => 'A new food listing has been posted!',
            'body' => 'We are excited to announce we have a new food listing named ' . ($foodListing->name ?? 'Unnamed Listing'),
            'url' => url('/dashboard'),
 
            'footer' => 'Team Food Sharing App',
        ];

        Mail::to($user->email)->queue(new FoodPostedNotification($details));

        // Save the email notification to the database
        $notification = new EmailNotification();
        $notification->user_id = $user->id;
        $notification->food_listing_id = $foodListing->id;
        $notification->is_read = false;
        $notification->subject = $emailSubject; // This should not be null or empty
        $notification->email_body = $details['body'];
        $notification->save();
    }
}


public function updateInputValue($inputId, $value) {
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