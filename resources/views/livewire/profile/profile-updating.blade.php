
    <section class="profile-content">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-grey-700 dark:bg-gray-500 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header class="mb-4">

                        <h2 class="text-lg font-bold text-black dark:text-gray-100">
                            {{ __('Profile Information') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>
                    </header>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <div>
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($isEditing)
                            <form wire:submit="save" class="mt-6 space-y-6">
                                @csrf
                                @method('patch') <div>
                                    <label for="username">{{ __('User name') }}</label>
                                    <input wire:model="username" id="username" type="text"
                                        class="mt-1 block w-full">
                                    @error('username')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="first_name">{{ __('First Name') }}</label>
                                    <input wire:model="first_name" id="first_name" type="text"
                                        class="mt-1 block w-full">
                                    @error('first_name')
                                        <span class="error text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_name">{{ __('Last Name') }}</label>
                                    <input wire:model="last_name" id="last_name" type="text"
                                        class="mt-1 block w-full">
                                    @error('last_name')
                                        <span class="error text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="bio">{{ __('Bio') }}</label>
                                    <input wire:model="bio" id="bio" type="text" class="mt-1 block w-full">
                                    @error('bio')
                                        <span class="error text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone_number">{{ __('Phone Number') }}</label>
                                    <input wire:model="phone_number" id="phone_number" type="text"
                                        class="mt-1 block w-full">
                                    @error('phone_number')
                                        <span class="error text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="date_of_birth">{{ __('Date of Birth') }}</label>
                                    <input wire:model="date_of_birth" id="date_of_birth" type="date"
                                        class="mt-1 block w-full">
                                    @error('date_of_birth')
                                        <span class="error text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="profile_picture">{{ __('Profile Picture') }}</label>
                                    <input wire:model="profile_picture" type="file" id="profile_picture"
                                        class="mt-1 block w-full" wire:change="updateProfilePicture">
                                    @error('profile_picture')
                                        <span class="error text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                    <div wire:loading wire:target="updateProfilePicture">Updating...</div>
                                    <div x-data="{ show: false }" x-init="@this.on('profile-picture-updated', () => {
                                        show = true;
                                        setTimeout(() => show = false, 10000);
                                    })" x-show="show"
                                        style="display: none;" class="mt-2 text-sm text-green-600">
                                        Profile picture updated successfully.
                                    </div>
                                </div>


                                <div>
                                    <label for="email">{{ __('Email') }}</label>
                                    <input wire:model="email" id="email" type="email" class="mt-1 block w-full">
                                    @error('email')
                                        <span class="error text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="flex items-center justify-end">
                                    <x-primary-button wire:click="notEditing">{{ __('Cancel') }}</x-primary-button>

                                    <x-primary-button wire:click="save">{{ __('Update Profile') }}</x-primary-button>
                                </div>


                            </form>
                        @else
                            <div class="bg-lime-400 text-white rounded-lg shadow px-6 py-4 max-w-3xl mx-auto">
                                <div class="flex justify-between items-center">
                                    <div class="flex-grow">
                                    </div>
                                    @if ($image_url)
                                        <img src="{{ $image_url }}" alt="Profile Picture"
                                            class="w-20 h-20 rounded-full border-2 border-white shadow-sm">
                                    @endif
                                </div>
                                <h2 class="text-xl font-semibold mb-2">Profile Information</h2>
                                <div class="mb-3">Username: {{ $username }}</div>
                                <div class="mb-3">First Name: {{ $first_name }}</div>
                                <div class="mb-3">Last Name: {{ $last_name }}</div>
                                <div class="mb-3">Bio: {{ $bio }}</div>
                                <div class="mb-3">Phone Number: {{ $phone_number }}</div>
                                <div class="mb-3">Date of Birth: {{ $date_of_birth }}</div>
                                <div class="mb-3">Email: {{ $email }}</div>

                            </div>
                            <div class="flex items-center justify-end">
                                <h1 class="font-bold alert-danger form-inline">Click here to edit profile </h1>
                                <x-primary-button wire:click="isEditingNow"
                                    class="btn-edit">{{ __(' Edit profile') }}</x-primary-button>
                            </div>
                        @endif
                    </div>
                </div>
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>


                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>

            </div>

</section>

