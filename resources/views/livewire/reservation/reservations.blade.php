<div x-data="{ showModal: @entangle('showModal'), isApplicationApproved: @entangle('isApplicationApproved') }">
    <!-- Reserve Button -->
    <button @click="showModal = true" class="px-4 py-2 bg-blue-500 text-white rounded-md">
        Reserve
    </button>

    <!-- Modal Backdrop -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" x-show="showModal" x-cloak
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
                            Since your application is not approved yet, please complete your application to proceed with
                            reservations.
                        </p>
                        <div class="mt-4 flex justify-center">
                            <a href="/application-form"
                                class="inline-flex justify-center w-full px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white rounded-md focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5">
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
                            <button @click="showModal = false"
                                class="px-4 py-2 bg-red-500 text-white rounded-md focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5 mr-2">
                                Cancel
                            </button>
                            <button @click="$wire.reserve()"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Reserve
                            </button>
                        </div>

                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
