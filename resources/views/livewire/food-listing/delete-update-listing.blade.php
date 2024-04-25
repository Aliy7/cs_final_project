<div class="relative">
    <!-- Vertical dot menu -->
    <button onclick="toggleDropdown()" class="p-2 focus:outline-none">
        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 4a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z" />
        </svg>
    </button>

    <!-- Options Menu -->
    <div id="optionsMenu" style="display: none;" class="absolute z-20 mt-2 py-2 w-48 bg-white rounded-md shadow-xl">
        @if (Auth::user()->hasRole('admin'))
            <a href="#" wire:click.prevent="editModal"
                class="block px-4 py-2 text-sm text-gray-800 hover:bg-blue-700 cursor-pointer">Edit</a>
            <a href="#" wire:click.prevent="deleteConfirmation"
                class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100 cursor-pointer">Delete</a>
        @endif
    </div>

    <!-- Edit Modal -->
    @if ($editModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                    <form wire:submit.prevent="updateFoodListing" class="space-y-4 p-4">
                        <input type="text" wire:model="foodListing.name" placeholder="Name" class="input w-full" />
                        <input type="text" wire:model="foodListing.ingredients" placeholder="Ingredients"
                            class="input w-full" />
                        <input type="number" wire:model="foodListing.quantity" placeholder="Quantity"
                            class="input w-full" />
                        <input type="text" wire:model="foodListing.allergen" placeholder="Allergens"
                            class="input w-full" />
                        <textarea wire:model="foodListing.description" placeholder="Description" class="textarea w-full"></textarea>
                        <select wire:model="foodListing.status" class="select w-full">
                            <option value="1">Available</option>
                            <option value="0">Unavailable</option>
                        </select>
                        <select wire:model="foodListing.category_id" class="select w-full">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-5 sm:mt-6 flex justify-end space-x-2">
                            <button type="button" wire:click="$set('editModal', false)" class="...">
                                Close
                            </button>
                            <button type="submit" class="...">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <!-- Delete Confirmation Modal -->
    @if ($deleteConfirmation)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                    <div class="text-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Deletion</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">Are you sure you want to delete this listing? This action
                                cannot be undone.</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteFoodListing" type="button" class="...">
                            Delete
                        </button>
                        <button type="button" wire:click="$set('deleteConfirmation', false)" class="...">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById('optionsMenu');
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }
</script>
