

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-4">Recent Food Listings</h3>
                @if ($foodListings && $foodListings->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        @foreach ($foodListings as $listing)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg flex flex-col items-center">
                            <div class="w-full flex justify-between items-center">
                                <div class="flex flex-col items-start">
                                    <span class="font-medium">Listed by:   <a href="#" class="text-blue-500 hover:text-blue-700 ml-1">
                                        {{ $listing->user->first_name ?? 'N/A' }}
                                    </a></span>
                                  
                                    <div class="text-sm">{{ $listing->created_at->diffForHumans() }}</div>
                                </div>
                                {{-- <div class="shrink-0">
                                    @livewire('edit-delete.edit-delete-component', ['foodListingId' => $listing->id], key('-component-' . $listing->id))
                                </div> --}}
                                <div class="shrink-0">
                                    @livewire('edit-delete.edit-delete-component', ['foodListingId' => $listing->id], key('edit-delete-component-' . $listing->id))
                                </div>
                            </div>
                           <!-- Image Container -->
                           <div class="image-section" style="width: 100%; display: block;">
                            @if ($listing->photo_url)
                                @php $imageUrls = json_decode($listing->photo_url, true); @endphp
                                @if (is_array($imageUrls) && count($imageUrls) > 0)
                                    <div style="display: flex; justify-content: center;">
                                        <img src="{{ asset('storage/' . $imageUrls[0]) }}" alt="Food Image" style="max-width: 100%; height: auto; border-radius: 20px;">
                                    </div>
                                @else
                                    <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
                                        <span>No images available.</span>
                                    </div>
                                @endif
                            @else
                                <div style="width: 100%; display: flex; justify-content: center; align-items: center;">
                                    <span>No image available</span>
                                </div>
                            @endif
                        </div>
                        
                            
                                <div class="text-lg font-semibold mt-4">{{ $listing->name }}</div>
                               
                                <div x-data="{ seeMore: false }">
                                    <button @click="seeMore = !seeMore" class="mt-2 text-blue-500 hover:text-blue-700 cursor-pointer">
                                        See More
                                    </button>
                                    <div x-show="seeMore" x-cloak>
                                        <div class="text-sm">Food description{{ $listing->description }}</div>
                                        <div>Quantity: {{ $listing->quantity }}</div>
                                        <div>Allergen: {{ $listing->allergen }}</div>
                                        <div>Status: 
                                            <span :class="{'bg-green-100 text-green-800': {{ $listing->status }}, 'bg-red-100 text-red-800': !{{ $listing->status }}}">
                                                {{ $listing->status ? 'Available' : 'Unavailable' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div x-data="{ open: false }">
                                    <button @click="open = !open" class="focus:outline-none">
                                        <img src="{{ asset('storage/logo/icons8-location (1).gif') }}" alt="Show Location" />
                                    </button>
                                    <div x-show="open" x-cloak>
                                        @if ($listing->location && $listing->location->latitude && $listing->location->longitude)
                                            <div id="map-{{ $listing->id }}" class="map-container w-full h-56"
                                                 x-init-map="open" 
                                                 data-listing-id="{{ $listing->id }}"
                                                 data-latitude="{{ $listing->location->latitude }}"
                                                 data-longitude="{{ $listing->location->longitude }}">
                                                <!-- The map will be initialized here -->
                                            </div>
                                        @else
                                            <div>No location available.</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="shrink-0">
                                    @livewire('reserve.reservations', ['food_listing_id' => $listing->id], key('reservations-component-' . $listing->id))
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $foodListings->links() }}
                @else
                    <p>No food listings available.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>


function initialize() {
    // This function will be called as the callback when the Google Maps API loads.
    initMap();
    loadGoogleMapsAPI();
}

function initMap() {
    document.querySelectorAll('[id^="map-"]').forEach(function(mapContainer) {
        const latitude = parseFloat(mapContainer.dataset.latitude);
        const longitude = parseFloat(mapContainer.dataset.longitude);
        // Only initialize the map if latitude and longitude are available
        if (latitude && longitude) {
            const map = new google.maps.Map(mapContainer, {
                center: { lat: latitude, lng: longitude },
                zoom: 15
            });
            new google.maps.Marker({
                position: { lat: latitude, lng: longitude },
                map: map
            });
        }
    });
}
document.addEventListener('alpine:init', () => {
    Alpine.directive('init-map', (el, { expression }, { evaluate }) => {
        Alpine.effect(() => {
            if (evaluate(expression)) {
                initMap();
            }
        });
    });
});
</script>