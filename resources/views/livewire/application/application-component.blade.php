<div class="container mx-auto p-5 application-content">
    @if(session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-md" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg shadow-md" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-xl">
        <h2 class="text-2xl font-semibold text-center mb-6">Application Form</h2>
        
        <!-- Family Income -->
        <div class="mb-4">
            <label for="family_income" class="block text-sm font-medium text-gray-700">Family Income</label>
            <input wire:model="family_income" id="family_income" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            @error('family_income') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input wire:model="name" id="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Street -->
        <div class="mb-4">
            <label for="street" class="block text-sm font-medium text-gray-700">Street</label>
            <input wire:model="street" id="street" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            @error('street') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- City -->
        <div class="mb-4">
            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
            <input wire:model="city" id="city" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            @error('city') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- State -->
        <div class="mb-4">
            <label for="state" class="block text-sm font-medium text-gray-700">State</label>
            <input wire:model="state" id="state" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            @error('state') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Postal Code -->
        <div class="mb-4">
            <label for="postalCode" class="block text-sm font-medium text-gray-700">Postal Code</label>
            <input wire:model="postalCode" id="postalCode" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            @error('postalCode') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Country -->
        <div class="mb-4">
            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
            <input wire:model="country" id="country" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            @error('country') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Is Student -->
        <div class="mb-6">
            <label for="is_student" class="flex items-center text-sm font-medium text-gray-700">
                <input wire:model="is_student" id="is_student" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <span class="ml-2">Are you a student?</span>
            </label>
            @error('is_student') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">
                Submit Application
            </button>
        </div>
    </form>
</div>
