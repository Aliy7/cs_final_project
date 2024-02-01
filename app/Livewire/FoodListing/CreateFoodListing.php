<?php

namespace App\Livewire\FoodListing;

use Livewire\Component;
use App\Models\Category;
use App\Models\FoodListing;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateFoodListing extends Component
{

    use WithFileUploads;

    public $name, $ingredients, $quantity, $allergen, $description, $status, $category_id;
    public $images = [];
    public $imageUrls = [];
    public $categories;

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
        // Redirecting in Livewire component, adapted for Livewire:
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
        // Directly assigning guarded properties:
        $foodListing->category_id = $this->category_id;
        $foodListing->user_id = Auth::id(); // Direct assignment

       
        if (!empty($this->images)) {
                        $imagePaths = [];
                        foreach ($this->images as $image) {
                            $fileName = $this->uploadImage($image);
                            array_push($imagePaths, $fileName);
                        }
                        $foodListing->photo_url = json_encode($imagePaths);
                    }
        $foodListing->save();
    });

    session()->flash('success', 'Food listing created successfully.');
    $this->reset(['name', 'ingredients', 'quantity', 'allergen', 'description', 'status', 'category_id', 'images']);
    $this->dispatch('foodListingCreated'); // Adapt this event name as needed
}
    public function render()
    {
        return view('livewire.food-listing.create-food-listing')
        ->layout('layouts.app');
    
}
public function testMethod()
{
    dd('Method called');
}

}
