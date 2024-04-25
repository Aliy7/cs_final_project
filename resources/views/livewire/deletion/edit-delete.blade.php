<div>
    <!-- Dropdown Trigger -->
    <div class="relative">
        <button onclick="toggleDropdown({{ $foodListingId }})" class="ellipsis-button bg-red-500">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M4 8h16M4 16h16" />
            </svg></button>
        <!-- Dropdown Menu -->

        <div id="dropdownMenu-{{ $foodListingId }}" style="display: none;"
            class="absolute right-0 mt-2 bg-blue-500 text-white font-bold py-1 px-1 overflow-hidden">
            <ul class="text-white-800">
                @if (auth()->check() && auth()->user()->hasRole('admin'))
                    <li>
                        <button onclick="confirmDeletion()" class="btn btn-danger">Delete</button>
                    </li>
                    <li>
                        <button wire:click="openEditModal({{ $foodListingId }})" class="btn btn-primary">Edit</button>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Edit Modal -->
    @if ($editModal)
        <div id="editModal" class="fixed inset-0  top-200 overflow-y-auto flex items-center justify-center z-10">
            <div class="flex items-center justify-right min-h-screen">
                <div class="fixed inset-0 bg-gray-500 opacity-75"></div>

                <div
                    class="bg-white rounded-lg overflow-hidden transform transition-all sm:w-full sm:max-w-4xl lg:max-w-6xl">
                    <form wire:submit.prevent="updateFoodListing" class="space-y-4 p-4">
                        <h2 class="text-lg font-medium text-gray-900">Edit Food Listing</h2>

                        <!-- Form content -->
                        <div class="space-y-4">
                            <div class="space-y-4">
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <textarea id="name" wire:model.defer="name" class="form-textarea mt-1 block w-full" rows="2"></textarea>
                                    @error('name')
                                        <span class="error text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="ingredients"
                                        class="block text-sm font-medium text-gray-700">Ingredients</label>
                                    <textarea id="ingredients" wire:model.defer="ingredients" class="form-textarea mt-1 block w-full" rows="3"></textarea>
                                    @error('ingredients')
                                        <span class="error text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="quantity"
                                        class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <input type="number" id="quantity" wire:model.defer="quantity" min="1"
                                        class="form-input mt-1 block w-full" />
                                    @error('quantity')
                                        <span class="error text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="allergen"
                                        class="block text-sm font-medium text-gray-700">Allergen</label>
                                    <textarea id="allergen" wire:model.defer="allergen" class="form-textarea mt-1 block w-full" rows="2"></textarea>
                                    @error('allergen')
                                        <span class="error text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" wire:model.defer="description" class="form-textarea mt-1 block w-full" rows="4"></textarea>
                                    @error('description')
                                        <span class="error text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <input type="checkbox" id="status" wire:model.defer="status"
                                        class="form-checkbox h-5 w-5 text-blue-600" value="1"><span
                                        class="ml-2 text-gray-700">Available</span>
                                    @error('status')
                                        <span class="error text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="category_id"
                                        class="block text-sm font-medium text-gray-700">Category</label>
                                    <select id="category_id" wire:model.defer="category_id"
                                        class="form-select mt-1 block w-full">
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="error text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="mt-5 sm:mt-6 flex justify-end space-x-2">
                                <button onclick="closeEditModal()" type="button" class="btn">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Alert messages -->
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>
<script>
    function toggleDropdown(foodListingId) {
        var dropdown = document.getElementById('dropdownMenu-' + foodListingId);
        if (dropdown) {
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        } else {
            console.error('No dropdown found with ID dropdownMenu-' + foodListingId);
        }
    }

    function confirmDeletion() {
        if (confirm("Are you sure you want to delete this food listing?")) {
            @this.call('deleteFoodListing');
        }
    }

    function openEditModal() {
        var modal = document.getElementById('editModal');
        modal.style.display = 'block';
        @this.call('loadFoodListing');
    }

    function closeEditModal() {
        var modal = document.getElementById('editModal');
        modal.style.display = 'none';
    }
    window.onclick = function(event) {
        if (!event.target.matches('.ellipsis-button')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    }
</script>
