<div class="container mx-auto p-5">
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
        Testing location Search
    </div>

    <form wire:submit.prevent="saveLocation" class="mt-5">
        <div class="mb-4">
            <label for="address-input" class="block text-gray-700 text-sm font-bold mb-2">Search Address:</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline map-input" id="address-input" wire:model="searchName">
        </div>

        <div id="address-map-container" class="w-full h-56 mb-4" style="width: 100%; height: 200px;">
            <div id="address-map" style="width: 100%; height: 100%;"></div>
        </div>

        <div class="mb-4">
            <label for="address-latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude:</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address-latitude" wire:model="latitude">
        </div>

        <div class="mb-4">
            <label for="address-longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude:</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address-longitude" wire:model="longitude">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
    </form>
</div>
