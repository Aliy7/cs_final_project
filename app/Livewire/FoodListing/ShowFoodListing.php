<?php

namespace App\Livewire\FoodListing;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\FoodListing;
use Livewire\WithPagination;

/**
 * The ShowFoodListing classs displays a paginated list of food listings.
 * It allows users to view all food listings with pagination support.
 */
class ShowFoodListing extends Component
{
    use WithPagination;

    public $foodListing;

    /**
     * Event listener Listens for Livewire events triggered by other components.
     *
     * @var array
     */
    protected $listeners = [
        'foodListingCreated' => 'handleFoodListingCreated',
        'redirectToApplicationForm' => 'handleRedirect',
        'foodListingDeleted' => '$FoodDeleted',
        'FoodListingIsDeleted' => '$FoodListingIsDeleted',
        'foodListingIsEdited' => '$foodListingIsEdited'

    ];

    /**
     * This function renders the component's view with the paginated food listings
     * Updates the food listing data when a new food listing is created.
     * 
     * @param mixed $foodListing The food listing data.
     * @return void
     */
    #[on('foodListingCreated')]
    public function updateFoodList($foodListing = null)
    {
    }

    /**
     * Renders the component.
     * 
     * @return \Illuminate\View\View The view for displaying food listings.
     */
    public function render()
    {
        return view('livewire.food-listing.show-food-listing', [
            'foodListings' => $this->getFoodListings(),
        ])->layout('livewire.app.app-layout');
    }

    /**
     * Retrieves paginated food listings from the database.
     * This function fetches paginated food listings from the database.
     * It orders the listings by creation date in descending order.
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated list of food listings.
     */
    public function getFoodListings()
    {
        return $foodlistings = FoodListing::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(4);
    }

    /**
     * Initializes the component with initial data.
     * This function initializes the component with the initial data
     * @return void
     */
    public function mount()
    {
        $this->foodListing = FoodListing::all();
    }
}
