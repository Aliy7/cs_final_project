<?php

namespace App\Livewire\EditDelete;

use Livewire\Component;
use App\Models\Category;
use App\Models\FoodListing;
use Illuminate\Support\Facades\Auth;

class EditDeleteComponent extends Component
{
public $foodListing;
public $showModal = false;
public $foodListingId, $name, $ingredients, $quantity, $allergen, $description, $status, $category_id;
public $isOpen = false;
public $editModal = false;
public $deleteModal = false;

public function mount($foodListingId)
{
    $this->foodListingId = $foodListingId;
    if ($foodListingId) {
        $this->foodListing = FoodListing::find($foodListingId);
    }
    $this ->getFoodListing();
}

public function openModal($foodListingId)
{
    $this->foodListingId = $foodListingId;
    $this->showModal = true;
}

public function closeModal()
{
    $this->showModal = false;
    $this->editModal = false;
}

public function deleteModal($id){
    $this->foodListing = $id;
$this->deleteModal = true;

$this->editModal = false;
$this->loadFoodListing();
}
public function confirmDeletion()
{
    if ($this->foodListingId) {
        $this->deleteFoodListing();
        $this->closeModal();
        $this->dispatch('confirmDeletion', $this->foodListingId);

    }
}


public function loadFoodListing()
{
    $this->foodListing = FoodListing::findOrFail($this->foodListingId);
}
public function openEditModal($id)
{
    $this->foodListing = $id;
    $this->editModal = true;
    $this->showModal = false; 
    $this->loadFoodListing();
}

public function closeEditModal(){
    $this->editModal = false;
}


public function render()
{
    $categories = Category::all(); 
    return view('livewire.deletion.edit-delete', compact('categories'));
}

public function toggleDropdown($foodListingId)
{
    if ($this->foodListingId === $foodListingId) {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->dispatch('dropdown-open');
        }
    }
}

public function closeDropdown()
{
    $this->isOpen = false;
}

public function deleteFoodListing()
{
    $foodListing = FoodListing::find($this->foodListingId);
    if (!$foodListing) {
        session()->flash('error', 'Food listing not found.');
        return;
    }

    if (Auth::user()->hasRole('admin') || $foodListing->user_id == Auth::id()) {
        $foodListing->delete();
        session()->flash('message', 'Food listing deleted successfully.');
        $this->dispatch('foodListingDeleted');
        $this->isOpen = false; 
    } else {
        session()->flash('error', 'Unauthorized action.');
    }
    $this->dispatch('FoodListingIsDeleted');
}

//editing section
    public function updateFoodListing()
    {
        $validated =  $this->validate([
            'foodListing.name' => 'required|string|max:200',
            'foodListing.ingredients' => 'required|string',
            'foodListing.quantity' => 'required|numeric|min:1|max:255',
            'foodListing.allergen' => 'required|string',
            'foodListing.description' => 'required|string|max:1000',
            'foodListing.status' => 'required|boolean',
            'foodListing.category_id' => 'required|exists:categories,id',
        ]);

        if ($this->foodListing) {
            $this->foodListing->update([
                'name' => $this->name,
                'ingredients' => $this->ingredients,
                'quantity' => $this->quantity,
                'allergen' => $this->allergen,
                'description' => $this->description,
                'status' => $this->status,
                'category_id' => $this->category_id,
            ]);

            session()->flash('message', 'Food listing updated successfully.');
            $this->resetEditing();
        } else {
            session()->flash('error', 'Food listing not found.');
        }
        $this->dispatch('foodListingIsEdited');
    }


    public function getFoodListing(){
        $this->foodListing = FoodListing::findOrFail($this->foodListingId);
        if ($this->foodListing) {
            $this->name = $this->foodListing->name;
            $this->ingredients = $this->foodListing->ingredients;
            $this->quantity = $this->foodListing->quantity;
            $this->allergen = $this->foodListing->allergen;
            $this->description = $this->foodListing->description;
            $this->status = $this->foodListing->status;
            $this->category_id = $this->foodListing->category_id;
        }

        
    }

    public function editFoodListing()
    {
        if (!Auth::check() || (Auth::user()->id != $this->foodListing->user_id && !Auth::user()->hasRole('admin'))) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $this->editModal = true;
    }

    public function resetEditing()
    {
        $this->editModal = false;
        $this->deleteModal = false;
        $this->clearForm();
    }

    private function clearForm()
    {
        $this->name = '';
        $this->ingredients = '';
        $this->quantity = '';
        $this->allergen = '';
        $this->description = '';
        $this->status = '';
        $this->category_id = '';
    }

}
