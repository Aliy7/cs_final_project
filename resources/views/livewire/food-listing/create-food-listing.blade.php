{{-- <div>
    {{-- Nothing in the world is as soft and yielding as water. --}}

    {{-- <h1> Food listing coming soon ..keep an eye out </h1>
</div> --}} 
<div>

    
    <form wire:submit.prevent="store" class="max-w-2xl mx-auto my-10 p-6 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-center mb-6">Create Food Listing</h2>

        Name Input
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Food Name">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Ingredients Input --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Ingredients</label>
            <input wire:model="ingredients" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Ingredients">
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

        {{-- Allergen Info Input --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Allergen Info</label>
            <input wire:model="allergen" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Allergen Info">
            @error('allergen') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Description Input --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea wire:model="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Description"></textarea>
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
            
            {{-- <select wire:model="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select> --}}
            @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Image Upload --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Images</label>
            <input wire:model="images" type="file" class="shadow w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
            @error('images.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <div class="mt-4">
                @if ($images)
                    @foreach ($images as $image)
                        <img src="{{ $image->temporaryUrl() }}" class="rounded-lg h-24 w-24 object-cover mr-2">
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-center mt-6">
            {{-- <x-primary-button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">{{ __('Create L') }}</x-primary-button> --}}

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Listing</button>

        </div>
    </form>
</div>
