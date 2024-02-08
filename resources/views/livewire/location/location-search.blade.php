<div class="container mx-auto p-5">
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
        Testing location Search
    </div>

    <form id="locationForm" method="POST" action="{{ route('saveLocation') }}">
        @csrf
        <div class="mb-4">
            <label for="address-input" class="block text-gray-700 text-sm font-bold mb-2">Search Address:</label>
            <input type="text" name="searchName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline map-input" id="address-input">
        </div>
        <div class="mb-4">
            <label for="address-latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude:</label>
            
           
            <input type="text" name="latitude" id="address-latitude" placeholder="Latitude" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

        </div>

        <div class="mb-4">
            <label for="address-longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude:</label>
            <input type="text" name="longitude" id="address-longitude" placeholder="Longitude" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
           
        </div>
        <div id="address-map-container" class="w-full h-56 mb-4" style="width: 100%; height: 200px;">
            <div id="address-map" style="width: 100%; height: 100%;"></div>
        </div>

        <input type="hidden" name="latitude" id="latitude-input">
        <input type="hidden" name="longitude" id="longitude-input">
        {{-- <input type="hidden" name="food_listing_id" value="your-food-listing-id-here"> --}}

        {{-- <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button> --}}
    </form>
</div>




<script>
    document.getElementById('locationForm').addEventListener('submit', function(e) {
        e.preventDefault();
         console.log("Latitude:", document.getElementById('latitude-input').value);
    console.log("Longitude:", document.getElementById('longitude-input').value);
        console.log("Form data before submission:", new FormData(this));

        const formData = new FormData(this);
    
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 422) {
                    // Handle validation errors
                    return response.json().then(errors => {
                        // Display validation errors to the user
                        console.error('Validation errors:', errors);
                    });
                }
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Handle success
            alert('Location saved successfully!');
        })
        .catch(error => {
            console.error('Error:', error); // Handle error
        });
    });
    </script>