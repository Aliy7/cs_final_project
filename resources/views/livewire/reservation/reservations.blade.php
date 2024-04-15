{{-- 

     <div>
        <!-- Reserve Button -->
        <button wire:click="toggleModal(true)" class="px-4 py-2 bg-blue-500 text-white rounded-md">Reserve</button>
    
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
             style="display: {{ $showModal ? 'flex' : 'none' }};"
             wire:click="toggleModal(false)">
    
            <!-- Modal Content -->
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6"
                 role="dialog"
                 aria-modal="true"
                 aria-labelledby="modal-headline"
                 wire:click.stop> <!-- Prevents click event from closing the modal when clicking inside -->
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">Confirm Reservation</h3>
                <div class="mt-2">
                    @if(!$isApplicationApproved)
                        <p class="text-sm leading-5 text-gray-500">
                            Since your application is not approved yet, please complete your application to proceed with reservations.
                        </p>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <a href="/application-form" class="inline-flex justify-center w-full px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-400 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Complete Application
                            </a>
                        </div>
                    @else
                        <p class="text-sm leading-5 text-gray-500">
                            Are you sure you want to reserve this item?
                        </p>
                        <!-- Reserve and Cancel buttons -->
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button wire:click="reserve" type="button" class="inline-flex justify-center w-full px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-400 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Reserve
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button type="button" wire:click="toggleModal(false)" class="inline-flex justify-center w-full px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Cancel
                                </button>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Livewire Event Listeners
            Livewire.on('redirectToApplicationForm', () => {
                window.location.href = '/application-form';
            });
    
            window.addEventListener('modal-message', event => {
            const data = event.detail;

            if(data.type === 'success'){
                alert(data.message); // Or use a more sophisticated notification system
                setTimeout(() => {
                    // Close the modal after a delay
                    Livewire.emit('closeModal');
                }, 3000); // Adjust the delay as needed
            } else if(data.type === 'error') {
                alert(data.message);
                // Keep the modal open or close it depending on your preference
            }
        });
    });
    </script>
     --}}
{{-- 
     <div x-data="{ showModal: @entangle('showModal'), isApplicationApproved: @entangle('isApplicationApproved') }">
        <!-- Reserve Button -->
        <button @click="showModal = true" class="px-4 py-2 bg-blue-500 text-white rounded-md">
            Reserve
        </button>
    
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
             x-show="showModal" 
             x-cloak
             @click.away="showModal = false">
            <!-- Modal Content -->
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md p-6"
                 @click.stop>
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Confirm Reservation
                </h3>
                <div class="mt-2">
                    <template x-if="!isApplicationApproved">
                        <p class="text-sm leading-5 text-gray-500">
                            Since your application is not approved yet, please complete your application to proceed with reservations.
                        </p>
                    </template>
                    <template x-if="isApplicationApproved">
                        <p class="text-sm leading-5 text-gray-500">
                            Are you sure you want to reserve this item?
                        </p>
                    </template>
                    
                    <!-- Reserve and Cancel buttons -->
                    <div class="mt-4 flex justify-end space-x-4">
                        <span class="mt-3 rounded-md shadow-sm">
                            <button @click="showModal = false" class="inline-flex justify-center px-4 py-2 bg-red-500 text-base leading-6 font-medium text-white rounded-md focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancel
                            </button>
                        </span>
                        <template x-if="isApplicationApproved">
                            <span class="rounded-md shadow-sm">
                                <button @click="$wire.reserve()" class="inline-flex justify-center px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white rounded-md focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Reserve
                                </button>
                            </span>
                        </template>
                        <template x-if="!isApplicationApproved">
                            <span class="rounded-md shadow-sm">
                                <a href="/application-form" class="inline-flex justify-center px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white rounded-md focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Complete Application
                                </a>
                            </span>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
     --}}

     <div x-data="{ showModal: @entangle('showModal'), isApplicationApproved: @entangle('isApplicationApproved') }">
        <!-- Reserve Button -->
        <button @click="showModal = true" class="px-4 py-2 bg-blue-500 text-white rounded-md">
            Reserve
        </button>
    
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
             x-show="showModal"
             x-cloak
             @click.away="showModal = false">
    
            <!-- Modal Content -->
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-sm p-6"
                 @click.stop>
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Confirm Reservation
                </h3>
                <div class="mt-2">
                    <template x-if="!isApplicationApproved">
                        <div>
                            <p class="text-sm leading-5 text-gray-500">
                                Since your application is not approved yet, please complete your application to proceed with reservations.
                            </p>
                            <div class="mt-4 flex justify-center">
                                <a href="/application-form" class="inline-flex justify-center w-full px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white rounded-md focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Complete Application
                                </a>
                            </div>
                        </div>
                    </template>
                    <template x-if="isApplicationApproved">
                        <div>
                            <p class="text-sm leading-5 text-gray-500">
                                Are you sure you want to reserve this item?
                            </p>
                            <!-- Reserve and Cancel buttons -->
                            <div class="mt-4 flex justify-end items-center">
                                <button @click="showModal = false" class="px-4 py-2 bg-red-500 text-white rounded-md focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5 mr-2">
                                    Cancel
                                </button>
                                <button @click="$wire.reserve()" class="px-4 py-2 bg-blue-500 text-white rounded-md focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Reserve
                                </button>
                            </div>                            
                                          
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    