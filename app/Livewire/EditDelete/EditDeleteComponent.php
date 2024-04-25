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
    public $foodListingId;
    public $name;
    public $ingredients;
    public $quantity;
    public $allergen;
    public $description;
    public $status;
    public $category_id;
    public $isOpen = false;
    public $editModal = false;
    public $deleteModal = false;

    /**
     * Mount the component and initialize the food listing.
     * This method is called when the component is initialized.
     * It retrieves the food listing data based on the provided ID.
     *
     * @param int $foodListingId The ID of the food listing to be edited or deleted.
     * @return void
     */
    public function mount($foodListingId)
    {
        $this->foodListingId = $foodListingId;
        if ($foodListingId) {
            $this->foodListing = FoodListing::find($foodListingId);
        }
        $this->getFoodListing();
    }

    /**
     * Open the edit/delete modal with the specified food listing ID.
     * This method sets the food listing ID and shows the modal.
     *
     * @param int $foodListingId The ID of the food listing.
     * @return void
     */
    public function openModal($foodListingId)
    {
        $this->foodListingId = $foodListingId;
        $this->showModal = true;
    }

    /**
     * Close the edit/delete modal.
     * This method hides the modal.
     *
     * @return void
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->editModal = false;
    }

    /**
     * Display the delete modal with the specified food listing ID.
     * This method sets the food listing ID and shows the delete modal.
     *
     * @param int $id The ID of the food listing.
     * @return void
     */
    public function deleteModal($id)
    {
        $this->foodListing = $id;
        $this->deleteModal = true;

        $this->editModal = false;
        $this->loadFoodListing();
    }
    /**
     * Confirm deletion of the food listing.
     * This method deletes the food listing from
     *  the database and dispatches a deletion event.
     *
     * @return void
     */
    public function confirmDeletion()
    {
        if ($this->foodListingId) {
            $this->deleteFoodListing();
            $this->closeModal();
            $this->dispatch('confirmDeletion', $this->foodListingId);
        }
    }

    /**
     * Load the food listing data from the database.
     * This method retrieves the food listing details based on the ID.
     *
     * @return void
     */
    public function loadFoodListing()
    {
        $this->foodListing = FoodListing::findOrFail($this->foodListingId);
    }

    /**
     * Open the edit modal with the specified food listing ID.
     * This method sets the food listing ID, shows the edit modal, and loads the food listing data.
     *
     * @param int $id The ID of the food listing.
     * @return void
     */
    public function openEditModal($id)
    {
        $this->foodListing = $id;
        $this->editModal = true;
        $this->showModal = false;
        $this->loadFoodListing();
    }

    /**
     * Close the edit modal.
     * This method hides the edit modal.
     *
     * @return void
     */
    public function closeEditModal()
    {
        $this->editModal = false;
    }

    /**
     * Render the component view.
     * This method returns the view for the edit-
     * delete component and passes the categories data to it.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $categories = Category::all();
        return view('livewire.deletion.edit-delete', compact('categories'));
    }

    /**
     * Toggle the dropdown state for the specified food listing ID.
     * This method toggles the dropdown state and dispatches-
     *  an event when the dropdown is opened.
     *
     * @param int $foodListingId The ID of the food listing.
     * @return void
     */
    public function toggleDropdown($foodListingId)
    {
        if ($this->foodListingId === $foodListingId) {
            $this->isOpen = !$this->isOpen;
            if ($this->isOpen) {
                $this->dispatch('dropdown-open');
            }
        }
    }

    /**
     * Close the dropdown.
     * This method closes the dropdown state.
     *
     * @return void
     */
    public function closeDropdown()
    {
        $this->isOpen = false;
    }

    /**
     * Delete the food listing from the database.
     * This method deletes the food listing if the user - 
     * has the necessary permissions.
     *
     * @return void
     */
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

    /**
     * Update the food listing with the provided data.
     * This method validates the input fields, updates the food listing in the database,
     * and dispatches an event to notify the system of the update.
     *
     * @return void
     */
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

    /**
     * Retrieve the food listing data from the database.
     * This method fetches the food listing details based on the provided ID
     * and assigns them to the component's properties.
     *
     * @return void
     */
    public function getFoodListing()
    {
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

    /**
     * Enable editing of the food listing.
     * This method checks user authentication and authorization
     * before allowing the food listing to be edited.
     *
     * @return void
     */
    public function editFoodListing()
    {
        if (!Auth::check() || (Auth::user()->id != $this->foodListing->user_id && !Auth::user()->hasRole('admin'))) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        $this->editModal = true;
    }

    /**
     * Reset the editing state.
     * This method resets the edit modal and delete modal states,
     * and clears the form fields.
     *
     * @return void
     */
    public function resetEditing()
    {
        $this->editModal = false;
        $this->deleteModal = false;
        $this->clearForm();
    }

    /**
     * Clear the form fields.
     * This method resets all the form fields to their initial empty state.
     *
     * @return void
     */
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
