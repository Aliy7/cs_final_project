<div class="max-w-3xl mx-auto sm:px-6 lg:px-8 email-content">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">
                Send Email Notifications
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Fill in the details below to send an email notification to users.
            </p>
            <form wire:submit.prevent="sendEmail" class="space-y-6 mt-8">
                <div>
                    <label for="foodQuantity" class="block text-sm font-medium text-gray-700">Food Quantity</label>
                    <input wire:model="foodQuantity" id="foodQuantity" type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter the number of available food items">
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Email Subject</label> 
                    <input wire:model="subject" id="subject" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter the email subject">
                </div>

                <div>
                    <label for="email_body" class="block text-sm font-medium text-gray-700">Email Body</label> 
                    <textarea wire:model="email_body" id="email_body" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter the email body"></textarea>
                </div>

                <div>
                    <label for="attachments" class="block text-sm font-medium text-gray-700">Attachments</label>
                    <input wire:model="attachments" id="attachments" type="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" multiple>
                    @error('attachments.*') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50"> Send Email </button>

                </div>
            </form>
        </div>
    </div>
</div> 
