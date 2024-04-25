/**
 * Function to asynchronously load the Google Maps API with the provided API key.
 */
function loadGoogleMapsAPI() {
    const script = document.createElement('script');
    const apiKey = 'AIzaSyD6T45Ph2qni_P8Hb_p1Y8E_J9SeGym2T4';
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places&callback=initialize`;
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);

}

// Load Google Maps API when the DOM content is loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadGoogleMapsAPI);
} else {

    loadGoogleMapsAPI();
}

/**
 * Function to initialize maps functionality.
 */
function initializeMaps() {
    if (document.getElementsByClassName("map-input").length > 0) {
        initAutocomplete();
    }

    if (document.querySelectorAll('[id^="view-map-"]').length > 0) {
        initViewMaps();
    }
}

/**
 * Function to initialize maps when the Google Maps API is loaded.
 */
function initialize() {

    $(document).ready(function () {
        $('form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    });

    const locationInputs = document.getElementsByClassName("map-input");

    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;
    // Initialize maps for each location input
    for (let i = 0; i < locationInputs.length; i++) {

        const input = locationInputs[i];
        const fieldKey = input.id.replace("-input", "");
        const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 59.339024834494886;
        const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 18.06650573462189;

        const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
            center: { lat: latitude, lng: longitude },
            zoom: 13
        });
        const marker = new google.maps.Marker({
            map: map,
            position: { lat: latitude, lng: longitude },
        });

        marker.setVisible(isEdit);

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({ input: input, map: map, marker: marker, autocomplete: autocomplete });
    }

    // Listen for changes in the autocomplete input fields
    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;


        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            marker.setVisible(true);

            const place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");

                return;
            }

            const locationName = place.name;
            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();
            setLocationCoordinates(autocomplete.key, lat, lng, locationName);

            geocoder.geocode({ 'placeId': place.place_id }, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const lat = results[0].geometry.location.lat();
                    const lng = results[0].geometry.location.lng();
                    setLocationCoordinates(autocomplete.key, lat, lng);
                }
            });

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                input.value = "";
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

        });
    }
}

/**
 * Function to set location coordinates.
 *
 * @param {string} key The key identifier for the location input field.
 * @param {number} lat The latitude value.
 * @param {number} lng The longitude value.
 * @param {string} searchName The name of the location.
 */
function setLocationCoordinates(key, lat, lng, searchName) {

    // Update Livewire-bound inputs with the new coordinates
    document.getElementById('address-latitude').value = lat;
    document.getElementById('address-longitude').value = lng;

    document.getElementById('address-latitude').dispatchEvent(new Event('input'));
    document.getElementById('address-longitude').dispatchEvent(new Event('input'));
    document.getElementById('address-input').dispatchEvent(new Event('input'));


}

// Initialize maps when the DOM content is loaded
document.addEventListener('DOMContentLoaded', loadGoogleMapsAPI);

// Load map initialization function when Livewire loads or refreshes

document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('load', () => {
        const savedPosition = localStorage.getItem('scrollPosition');
        if (savedPosition) {
            setTimeout(() => {
                window.scrollTo(0, parseInt(savedPosition));
                localStorage.removeItem('scrollPosition');
            }, 0);
        }
    });

    Livewire.on('beforeunload', () => {
        localStorage.setItem('scrollPosition', window.scrollY || document.documentElement.scrollTop);
    });
});

if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}


//Reference this javascript code acquired from google .com but I have tweaked, improved made it to meet ma apps interest
//Url : https://developers.google.com/maps/documentation/javascript/examples/map-geolocation?

