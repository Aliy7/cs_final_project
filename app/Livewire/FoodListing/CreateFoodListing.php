<?php

namespace App\Livewire\FoodListing;

use Livewire\Component;
use App\Models\Category;
use App\Models\FoodListing;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

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
    public function store()
    {
        $this->validate();

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $imagePaths = [];
        foreach ($this->images as $image) {
            $fileName = $this->uploadImage($image);
            array_push($imagePaths, $fileName);
        }

        FoodListing::create([
            'name' => $this->name,
            'ingredients' => $this->ingredients,
            'quantity' => $this->quantity,
            'allergen' => $this->allergenInfo,
            'description' => $this->description,
            'photoUrl' => json_encode($imagePaths), 
            'status' => $this->status,
            'category_id' => $this->category_id,
            'user_id' => Auth::id(), 
        ]);

        session()->flash('success', 'Food listing created successfully.');
        $this->reset(['name', 'ingredients', 'quantity', 'allergenInfo', 'description', 'status', 'category_id', 'images']);
    }
    public function uploadImage($image)
    {
        $fileName = 'food_images/' . Str::random(40) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public', $fileName);
        return $fileName;
    }

    public function render()
    {
        return view('livewire.food-listing.create-food-listing')
        ->layout('layouts.app');
    
}
}
