<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-4">Recent Food Listings</h3>
                @if ($foodListings && $foodListings->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        @foreach ($foodListings as $listing)
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg flex flex-col items-center">
                                <div class="text-center mb-4">
                                    <span class="font-medium">Listed by:</span>
                                    <a href="#" class="text-blue-500 hover:text-blue-700">
                                        {{ $listing->user->first_name ?? 'N/A' }}
                                    </a>
                                    <div>{{ $listing->created_at->diffForHumans() }}</div>
                                </div>
                                @if ($listing->photo_url)
                                    @php $imageUrls = json_decode($listing->photo_url, true); @endphp
                                    @if(is_array($imageUrls) && count($imageUrls) > 0)
                                        <!-- Adjusted image size for a larger display -->
                                        <img src="{{ asset('storage/' . $imageUrls[0]) }}" alt="Food Image" class="rounded-lg mb-4" style="width: auto; height: 200px;">
                                    @else
                                        <div>No images available.</div>
                                    @endif
                                @else
                                    <div>No image available</div>
                                @endif
                                <div class="text-lg font-semibold mt-4">{{ $listing->name }}</div>
                                <div class="text-sm">{{ $listing->description }}</div>
                                <div>Quantity: {{ $listing->quantity }}</div>
                                <div>Allergen: {{ $listing->allergen }}</div>
                                <div>Status: {{ $listing->status ? 'Available' : 'Unavailable' }}</div>
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