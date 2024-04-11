<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h1 class="text-3xl font-bold ">Fill user details in the form</h1>
        <hr class="h-1 bg-gray-300 border-0">
        <!-- Name -->
        <div>
            <label for="username" class=" font-bold text-gray-700">User Name</label>
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" placeholder="User Name here" required autofocus autocomplete="username" maxlength="15" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                <div id="usernameError" class="text-red-500 text-sm hidden"></div>  
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class=" font-bold text-gray-700">Email </label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Your Email" autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- Name -->
        <div>
            <label for="first_name" class=" font-bold text-gray-700">First Name</label>
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" placeholder="First Name" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

         <!-- Name -->
         <div>
            <label for="last_name" class=" font-bold text-gray-700">Surname</label>
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" placeholder="Surname" autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!--Phone Number-->
        <div>
            <label for="phone_number" class="font-bold text-gray-700">Phone Number</label>
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" placeholder="Phone Number" required autofocus autocomplete="phone_number" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            <div id="phoneNumberError" class="text-red-500 text-sm hidden"></div>  
        </div>
      {{-- <!-- Password -->
      <div class="mt-4">
        <label for="password" class=" font-bold text-gray-700">Password</label>

        <x-text-input id="password" class="block mt-1 w-full" placeHolder="Enter password"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <label for="password_confirmation" class=" font-bold text-gray-700">Repeat Password</label>


        <x-text-input id="password_confirmation" class="block mt-1 w-full" placeHolder="Repeat Password" 
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div> --}}
<!-- Password -->
<div class="mt-4">
    <label for="password" class="font-bold text-gray-700">Password</label>
    <x-text-input id="password" class="block mt-1 w-full" placeholder="Enter password"
                  type="password"
                  name="password"
                  required autocomplete="new-password" />
    <div class="text-sm text-gray-600">
        Atleast 12 characters and 2 must be special characters with a mix of uppercase and lowercase.
    </div>
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <label for="password_confirmation" class="font-bold text-gray-700">Repeat Password</label>
    <x-text-input id="password_confirmation" class="block mt-1 w-full" placeholder="Repeat password"
                  type="password"
                  name="password_confirmation" required autocomplete="new-password" />
    <div class="text-sm text-gray-600">
        Make sure your password matches the criteria above.
    </div>
    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    const phoneInput = document.getElementById('phone_number');
    const emailInput = document.getElementById('email');
    const usernameInput = document.getElementById('username');
    
    const phoneErrorContainer = document.getElementById('phoneNumberError');
    const usernameErrorContainer = document.getElementById('usernameError');
    const emailErrorContainer = document.getElementById('emailError');

    // Phone number validation
    phoneInput.addEventListener('input', () => {
        if (phoneInput.value.length > 11) {
            displayError(phoneErrorContainer, 'Phone number must be 11 digits.');
        } else {
            resetError(phoneErrorContainer);
        }
    });

   
    usernameInput.addEventListener('input', () => {
        const usernameValue = usernameInput.value.trim();

        // Perform AJAX call to check username uniqueness
        fetch('/check-username-uniqueness', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // Include CSRF token as needed for Laravel applications
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ username: usernameValue })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.isUnique) {
                // Show error if username is taken
                usernameErrorContainer.classList.remove('hidden');
            } else {
                // Hide error if username is unique
                usernameErrorContainer.classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Optionally handle the error, e.g., show a generic error message
        });
    });

    // Email validation
    emailInput.addEventListener('input', () => {
        isEmailTaken(emailInput.value, emailErrorContainer);
    });

  

    function isEmailTaken(email, errorContainer) {
        fetch('/check-email-uniqueness', {  
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.isUnique) { 
                resetError(errorContainer);
            } else {
                displayError(errorContainer, 'This email has been used already. Try a new one.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            displayError(errorContainer, 'An error occurred while checking the email.');
        }); 
    }

    function displayError(errorContainer, message) {
        errorContainer.textContent = message;
        errorContainer.classList.remove('hidden');
    }

    function resetError(errorContainer) {
        errorContainer.textContent = '';
        errorContainer.classList.add('hidden');
    }

</script>
