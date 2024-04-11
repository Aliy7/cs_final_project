<div class="container mx-auto p-5">

  
    <form wire:submit.prevent="store" class="max-w-2xl mx-auto my-10 p-6 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-center mb-6">Create Food Listing</h2>
       
         <!-- Name Input -->
         <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input wire:model="name" id="name-input" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Food Name">
            <ul id="name-suggestions" class="absolute z-10 list-disc bg-white border mt-1 hidden"></ul>
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <!-- Ingredients Input -->
        <div class="mb-4">
            <label for="ingredients" class="block text-gray-700 text-sm font-bold mb-2">Ingredients</label>
            <input wire:model="ingredients" id="ingredients-input" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingredients">
            <ul id="ingredients-suggestions" class="absolute z-10 list-disc bg-white border mt-1 hidden"></ul>
            @error('ingredients') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        {{-- Quantity Dropdown --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
            <select wire:model="quantity" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @for ($i = 1; $i <= 255; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

         <!-- Allergen Info Input -->
         <div class="mb-4">
            <label for="allergen" class="block text-gray-700 text-sm font-bold mb-2">Allergen Info</label>
            <input wire:model="allergen" id="allergen-input" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Allergen Info">
            <ul id="allergen-suggestions" class="absolute z-10 list-disc bg-white border mt-1 hidden"></ul>
            @error('allergen') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

     <!-- Description Input -->
     <div class="mb-4">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
        <textarea wire:model="description" id="description-input" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Description"></textarea>
        <ul id="description-suggestions" class="absolute z-10 list-disc bg-white border mt-1 hidden"></ul>
        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

        {{-- Status Checkbox --}}
        <div class="mb-4">
            <label class="flex items-center">
                <input wire:model="status" type="checkbox" class="form-checkbox h-5 w-5 text-gray-600"><span class="ml-2 text-gray-700">Available</span>
            </label>
            @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Category Dropdown --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
            <select wire:model="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
          
            @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Image Upload --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Images</label>
            <input wire:model.lazy="images" type="file" class="shadow w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
            @error('images.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <div class="mt-4">
                @if ($images)
                    @foreach ($images as $image)
                        <img src="{{ $image->temporaryUrl() }}" class="rounded-lg h-24 w-24 object-cover mr-2">
                    @endforeach
                @endif
            </div>
        </div>
                   {{-- Location Search Integration --}}
  
                   
        <div class="bg-blue-100 border border-blue-400 font-bold text-sky-400 px-4 py-3 rounded relative" role="alert">
            Add Pick Location
        </div>
        <div class="mb-4">
            <label for="address-input" class="block text-gray-700 text-sm font-bold mb-2">Search Address:</label>
            <input type="text" wire:model="searchName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline map-input" id="address-input">
        </div>
        <div class="mb-4">
            <label for="address-latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude:</label>
            <input type="text" wire:model="latitude" placeholder="latitude coordiates" id="address-latitude" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="address-longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude:</label>
            <input type="text" wire:model="longitude" placeholder="longitude coordinates" id="address-longitude" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div id="address-map-container" class="w-full h-56 mb-4" style="width: 100%; height: 200px;">
            <div id="address-map" style="width: 100%; height: 100%;"></div>
           
        </div>
   
       
       
{{--       
     
        {{-- Submit Button --}}
        <div class="flex justify-center mt-6">
            {{-- <x-primary-button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">{{ __('Create L') }}</x-primary-button> --}}

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Listing</button>

        </div>

    </form>
</div>

     <script>
        // Global timeout reference
        let hideSuggestionsTimeout;
    
        document.addEventListener('DOMContentLoaded', () => {
            setupAutocomplete('foodNames', 'name-input', 'name-suggestions');
            setupAutocomplete('foodIngredients', 'ingredients-input', 'ingredients-suggestions');
            setupAutocomplete('description', 'description-input', 'description-suggestions');
            setupAutocomplete('allergens', 'allergen-input', 'allergen-suggestions');
    
            // Add event listener to clear suggestions when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.matches('#name-input, #ingredients-input, #description-input, #allergen-input')) {
                    clearAllSuggestions();
                }
            });
        });
    
        function setupAutocomplete(endpoint, inputId, suggestionsId) {
            const inputElement = document.getElementById(inputId);
            inputElement.addEventListener('input', () => {
                // Clear the timeout each time the input is modified
                clearTimeout(hideSuggestionsTimeout);
                fetchAutocompleteSuggestions(inputElement.value, endpoint, inputId, suggestionsId);
            });
        }
    
        function fetchAutocompleteSuggestions(query, endpoint, inputId, suggestionsId) {
            if (query.length < 2) {
                clearSuggestions(suggestionsId);
                return;
            }
    
            const searchUrl = `https://foodsharing.io/api/autocomplete/${endpoint}?q=${encodeURIComponent(query)}`;
    
            fetch(searchUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(suggestions => {
                    displaySuggestions(suggestions, inputId, suggestionsId);
                })
                .catch(error => {
                    console.error('Error fetching autocomplete suggestions:', error);
                    clearSuggestions(suggestionsId);
                });
        }
    
        function displaySuggestions(suggestions, inputId, suggestionsId) {
            const suggestionsElement = document.getElementById(suggestionsId);
            clearSuggestions(suggestionsId);
    
            if (suggestions.length > 0) {
                suggestionsElement.classList.remove('hidden');
            }
    
            suggestions.forEach(suggestion => {
                const listItem = document.createElement('li');
                listItem.textContent = suggestion;
                listItem.className = 'p-2 cursor-pointer hover:bg-gray-200';
                listItem.addEventListener('click', function() {
                    const targetInput = document.getElementById(inputId);
                    targetInput.value = this.textContent;
                    targetInput.dispatchEvent(new Event('input'));
                    clearSuggestions(suggestionsId);
                });
                suggestionsElement.appendChild(listItem);
            });
    
            // Set a new timeout to hide suggestions after 5 seconds
            hideSuggestionsTimeout = setTimeout(() => {
                clearSuggestions(suggestionsId);
            }, 5000);
        }
    
        function clearSuggestions(suggestionsId) {
            const suggestionsElement = document.getElementById(suggestionsId);
            if (suggestionsElement) {
                suggestionsElement.innerHTML = '';
                suggestionsElement.classList.add('hidden');
            }
        }
    
        function clearAllSuggestions() {
            ['name-suggestions', 'ingredients-suggestions', 'description-suggestions', 'allergen-suggestions'].forEach(clearSuggestions);
        }
    </script>
    