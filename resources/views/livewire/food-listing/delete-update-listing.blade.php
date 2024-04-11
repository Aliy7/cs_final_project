{{-- 
<div x-data="{ open: false, editModalOpen: false, deleteConfirmationOpen: false }" class="relative">
    <!-- Vertical dot menu -->
    <button @click="open = !open" class="p-2 focus:outline-none">
        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 4a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z" />
        </svg>
    </button>
  
    <!-- Options Menu -->
    <div x-show="open" @click.away="open = false" class="absolute z-20 mt-2 py-2 w-48 bg-white rounded-md shadow-xl">
        @if (Auth::user()->hasRole('admin'))
            <a @click="editModalOpen = true; open = false" class="block px-4 py-2 text-sm text-gray-800 hover:bg-blue-700 cursor-pointer">
                Edit
            </a>
            <a @click="deleteConfirmationOpen = true; open = false" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100 cursor-pointer">
                Delete
            </a>
        @endif
    </div>

    <!-- Edit Modal -->
    <div x-show="editModalOpen" @click.away="editModalOpen = false" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" x-cloak>
        <!-- Add your form inside this div -->
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                <!-- Add your form fields here -->
                <!-- ... -->
                <!-- Close and Save buttons -->
                 <!-- Edit form with Livewire bindings -->
                 <form wire:submit.prevent="updateFoodListing" class="space-y-4 p-4">
                    <input type="text" wire:model="foodListing.name" placeholder="Name" class="input w-full" />
                    <input type="text" wire:model="foodListing.ingredients" placeholder="Ingredients" class="input w-full" />
                    <input type="number" wire:model="foodListing.quantity" placeholder="Quantity" class="input w-full" />
                    <input type="text" wire:model="foodListing.allergen" placeholder="Allergens" class="input w-full" />
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
                    <!-- Close and Save buttons -->
                    <div class="mt-5 sm:mt-6 flex justify-end space-x-2">
                        <button @click="editModalOpen = false" type="button" class="inline-flex justify-center w-auto px-4 py-2 bg-gray-200 text-base font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Close
                        </button>
                        <button type="submit" class="inline-flex justify-center w-auto px-4 py-2 bg-blue-600 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="deleteConfirmationOpen" @click.away="deleteConfirmationOpen = false" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" x-cloak>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                <!-- Confirmation message -->
                <div class="text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Deletion</h3>
                <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Are you sure you want to delete this listing? This action cannot be undone.</p>
                </div>
                </div>
                <!-- Confirmation buttons -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button @click="$wire.deleteFoodListing(); deleteConfirmationOpen = false" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Delete
                </button>
                </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button @click="deleteConfirmationOpen = false" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Cancel
                </button>
                </span>
                </div>
                </div>
                </div>
                </div>
                

                <!-- Flash messages -->
                @if (session()->has('message'))
                    <div class="fixed bottom-0 right-0 mb-4 mr-4 bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 shadow-md" role="alert">
                        <p class="font-bold">{{ session('message') }}</p>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="fixed bottom-0 right-0 mb-4 mr-4 bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3 shadow-md" role="alert">
                        <p class="font-bold">{{ session('error') }}</p>
                    </div>
                @endif
                </div> --}}

{{-- 

                <div x-data="{ open: false, editModalOpen: false, deleteConfirmationOpen: false }" class="relative">
                    <!-- Vertical dot menu -->
                    <button @click="open = !open" class="p-2 focus:outline-none">
                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 4a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>
                
                    <!-- Options Menu -->
                    <div x-show="open" @click.away="open = false" class="absolute z-20 mt-2 py-2 w-48 bg-white rounded-md shadow-xl">
                        @if (Auth::user()->hasRole('admin'))
                            <a href="#" @click="editModalOpen = true; open = false" class="block px-4 py-2 text-sm text-gray-800 hover:bg-blue-700 cursor-pointer">
                                Edit
                            </a>
                            <a href="#" @click="deleteConfirmationOpen = true; open = false" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100 cursor-pointer">
                                Delete
                            </a>
                        @endif
                    </div>
                
                    <!-- Edit Modal -->
                    <div x-show="editModalOpen" @click.away="editModalOpen = false" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" x-cloak>
                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
                            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                                <form wire:submit.prevent="updateFoodListing" class="space-y-4 p-4">
                                    <!-- Form fields -->
                                    <input type="text" wire:model="foodListing.name" placeholder="Name" class="input w-full" />
                                    <input type="text" wire:model="foodListing.ingredients" placeholder="Ingredients" class="input w-full" />
                                    <input type="number" wire:model="foodListing.quantity" placeholder="Quantity" class="input w-full" />
                                    <input type="text" wire:model="foodListing.allergen" placeholder="Allergens" class="input w-full" />
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
                                    <!-- Close and Save buttons -->
                                    <div class="mt-5 sm:mt-6 flex justify-end space-x-2">
                                        <button @click="editModalOpen = false" type="button" class="...">
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
                <!-- Delete Confirmation Modal -->
    <div x-show="deleteConfirmationOpen" @click.away="deleteConfirmationOpen = false" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" x-cloak>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                <!-- Confirmation message -->
                <div class="text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Deletion</h3>
                <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Are you sure you want to delete this listing? This action cannot be undone.</p>
                </div>
                </div>
                <!-- Confirmation buttons -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button @click="$wire.deleteFoodListing(); deleteConfirmationOpen = false" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Delete
                </button>
                </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button @click="deleteConfirmationOpen = false" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Cancel
                </button>
                </span>
                </div>
                </div>
                </div>
                </div>
                    <!-- Delete Confirmation Modal -->
                    <!-- ...Your delete modal content... -->
                
                    <!-- Flash messages -->
                    <!-- ...Your flash messages... -->
                </div>
                
                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('dropdown', () => ({
                            open: false,
                            toggle() {
                                this.open = !this.open;
                            }
                        }));
                    });
                </script> --}}


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
                            <a href="#" wire:click.prevent="editModal" class="block px-4 py-2 text-sm text-gray-800 hover:bg-blue-700 cursor-pointer">Edit</a>
                            <a href="#" wire:click.prevent="deleteConfirmation" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100 cursor-pointer">Delete</a>
                        @endif
                    </div>
                
                    <!-- Edit Modal -->
                    @if($editModal)
                        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
                            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
                                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                                    <form wire:submit.prevent="updateFoodListing" class="space-y-4 p-4">
                                        <input type="text" wire:model="foodListing.name" placeholder="Name" class="input w-full" />
                                        <input type="text" wire:model="foodListing.ingredients" placeholder="Ingredients" class="input w-full" />
                                        <input type="number" wire:model="foodListing.quantity" placeholder="Quantity" class="input w-full" />
                                        <input type="text" wire:model="foodListing.allergen" placeholder="Allergens" class="input w-full" />
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
                    @if($deleteConfirmation)
                        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
                            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
                                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                                    <div class="text-center">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Deletion</h3>
                                        <div class="mt-2 px-7 py-3">
                                            <p class="text-sm text-gray-500">Are you sure you want to delete this listing? This action cannot be undone.</p>
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
                