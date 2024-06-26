<div class="container mx-auto p-5 application-content">
    <form wire:submit.prevent="submit" onsubmit="applicationSubmitted()"
        class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-xl">
        <h2 class="text-2xl font-semibold text-center mb-6">Application Form</h2>
        <div id="processing-message" class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg shadow-md hidden"
            role="alert">
            Processing your application... Please wait.
        </div>
        <!-- Family Income -->
        <div class="mb-4">
            <label for="family_income" class="font-bold text-gray-700">Family Income</label>
            <input wire:model="family_income" placeholder="Only Number Allowed" id="family_income" type="number"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring 
             focus:ring-indigo-500 focus:ring-opacity-50 placeholde">
            @error('family_income')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="name" class="font-medium text-gray-700">Name is Entered for you: No need to update</label>
            <div id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2">
                {{ $name }}
            </div>
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Street -->
        <div class="mb-4">
            <label for="street" class=" font-bold text-gray-700">Street</label>
            <input wire:model="street" placeholder="Street name here..." id="street" type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            @error('street')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- City Input -->
        <div class="mb-4">
            <label for="city" class=" align-content-center font-bold text-gray-700">City</label>
            <input wire:model="city" placeholder="City name here.." id="city-input" type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" autocomplete="off">
            <ul id="city-suggestions" class="absolute z-10 list-disc bg-white border mt-1 hidden"></ul>
            @error('city')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- County Input -->
        <div class="mb-4">
            <label for="county" class=" font-bold text-gray-700">County</label>
            <input wire:model="county" placeholder="Your county here .." id="county-input" type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" autocomplete="off">
            <ul id="county-suggestions" class="absolute z-10 list-disc bg-white border mt-1 hidden"></ul>
            @error('county')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Postal Code -->
        <div class="mb-4">
            <label for="postcode" class=" font-bold text-gray-700">Postal Code</label>
            <input wire:model="postcode" placeholder="Post code here..." id="postcode" type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            @error('postalcode')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>


        <div class="mb-4">
            <label for="country" class="font-bold text-gray-700">Country</label>
            <input wire:model="country" placeholder="your country here..." id="country-input" type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" autocomplete="off">
            <ul id="country-suggestions" class="absolute z-10 list-disc bg-white border mt-1 hidden"></ul>
            @error('country')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Is Student -->
        <div class="mb-6">
            <label for="is_student" class="flex items-center text-sm font-medium text-gray-700">
                <input wire:model="is_student" id="is_student" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <span class="ml-2">Are you a student?</span>
            </label>
            @error('is_student')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div id="success-message" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-md hidden"
            role="alert">
            Your application has been successfully submitted! Now redirecting you to the dashboard...
        </div>

        <div class="flex justify-end">
            <button type="submit" onclick="submissionMessage()"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">
                Submit Application
            </button>
        </div>
        <div id="success-message" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-md hidden"
            role="alert">
            Your application has been successfully submitted!
        </div>
    </form>
</div>

@if (session()->has('message'))
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-md" role="alert">
        {{ session('message') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg shadow-md" role="alert">
        {{ session('error') }}
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setupAutocomplete('cities', 'city-input', 'city-suggestions');
        setupAutocomplete('counties', 'county-input', 'county-suggestions');
        setupAutocomplete('countries', 'country-input', 'country-suggestions');
        document.addEventListener('click', function(event) {
            if (!event.target.matches('#city-input') && !event.target.matches('#county-input') && !event
                .target.matches('#country-input')) {
                clearAllSuggestions();
            }
        });
    });

    function setupAutocomplete(endpoint, inputId, suggestionsId) {
        const inputElement = document.getElementById(inputId);
        inputElement.addEventListener('input', () => {
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

    let hideSuggestionsTimeout;

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

        clearTimeout(hideSuggestionsTimeout);

        hideSuggestionsTimeout = setTimeout(() => {
            clearSuggestions(suggestionsId);
        }, 10000);
    }


    function clearSuggestions(suggestionsId) {
        const suggestionsElement = document.getElementById(suggestionsId);
        if (suggestionsElement) {
            suggestionsElement.innerHTML = '';
            suggestionsElement.classList.add('hidden');
        }
    }

    function clearAllSuggestions() {
        ['city-suggestions', 'county-suggestions', 'country-suggestions'].forEach(suggestionsId => {
            clearSuggestions(suggestionsId);
        });
    }

    function applicationSubmitted() {
        document.getElementById('processing-message').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('processing-message').classList.add('hidden');
            document.getElementById('success-message').classList.remove('hidden');
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 5000);
        }, 2000);
    }
</script>
