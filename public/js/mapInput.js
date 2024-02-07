function loadGoogleMapsAPI() {
    const script = document.createElement("script");
    const apiKey = "AIzaSyD6T45Ph2qni_P8Hb_p1Y8E_J9SeGym2T4";
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places&callback=initialize`;
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", loadGoogleMapsAPI);
} else {
    loadGoogleMapsAPI();
}
function initialize() {
    $("form").on("keyup keypress", function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    const locationInputs = document.getElementsByClassName("map-input");

    const autocompletes = [];
    const geocoder = new google.maps.Geocoder();
    for (let i = 0; i < locationInputs.length; i++) {
        const input = locationInputs[i];
        const fieldKey = input.id.replace("-input", "");
        const isEdit =
            document.getElementById(fieldKey + "-latitude").value != "" &&
            document.getElementById(fieldKey + "-longitude").value != "";

        const latitude =
            parseFloat(document.getElementById(fieldKey + "-latitude").value) ||
            59.339024834494886;
        const longitude =
            parseFloat(
                document.getElementById(fieldKey + "-longitude").value
            ) || 18.06650573462189;

        const map = new google.maps.Map(
            document.getElementById(fieldKey + "-map"),
            {
                center: { lat: latitude, lng: longitude },
                zoom: 13,
            }
        );
        const marker = new google.maps.Marker({
            map: map,
            position: { lat: latitude, lng: longitude },
        });

        marker.setVisible(isEdit);

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({
            input: input,
            map: map,
            marker: marker,
            autocomplete: autocomplete,
        });
    }

    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;

        google.maps.event.addListener(
            autocomplete,
            "place_changed",
            function () {
                marker.setVisible(true);

                const place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }

                const locationName = place.name;
                const lat = place.geometry.location.lat();
                const lng = place.geometry.location.lng();
                setLocationCoordinates(
                    autocomplete.key,
                    lat,
                    lng,
                    locationName
                );

                geocoder.geocode(
                    { placeId: place.place_id },
                    function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            const lat = results[0].geometry.location.lat();
                            const lng = results[0].geometry.location.lng();
                            setLocationCoordinates(autocomplete.key, lat, lng);
                        }
                    }
                );

                if (!place.geometry) {
                    window.alert(
                        "No details available for input: '" + place.name + "'"
                    );
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
            }
        );
    }
}

function setLocationCoordinates(key, lat, lng) {
    document.getElementById("latitude-input").value = lat;
    document.getElementById("longitude-input").value = lng;
}

document
    .getElementById("locationForm")
    .addEventListener("submit", function (e) {
        e.preventDefault();

        console.log(
            "Latitude:",
            document.getElementById("latitude-input").value
        );
        console.log(
            "Longitude:",
            document.getElementById("longitude-input").value
        );

        const formData = new FormData(this);
    });

document.addEventListener("DOMContentLoaded", loadGoogleMapsAPI);
