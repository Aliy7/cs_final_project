<?php

namespace App\Livewire\FoodListing;
use Livewire\Component;
use App\Models\Category;
use App\Models\FoodListing;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Livewire\App\AppLayout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CreateFoodListing extends Component
{

    use WithFileUploads;

    public $name, $ingredients, $quantity, $allergen, $description, $status, $category_id;
    public $latitude, $longitude, $searchName, $food_listing_id;
    public $images = [];
    public $imageUrls = [];
    public $categories;

    protected $listeners = [
        "updateLocationCoordinates" => 'setLocation'
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

        DB::transaction(function () {
            $foodListing = new FoodListing();
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

            $this->dispatch('foodListingCreated');
        });
        $this->reset('name', 'ingredients', 'quantity', 'allergen', 'description', 'status', 'category_id', 'images', 'latitude', 'longitude', 'searchName');
// $this->reset(['name', 'ingredients', 'quantity', 'allergen', 'description', 'status', 'category_id', 'images']);

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

}
