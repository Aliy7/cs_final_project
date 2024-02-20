<div x-data="{ showModal: false }"> 
    <button @click="showModal = true" class="px-4 py-2 bg-blue-500 text-white rounded-md">Reserve</button>

    <!-- Modal Backdrop -->
    <div x-show="showModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" x-cloak>
        <!-- Clicking on the backdrop will close the modal -->
        <div class="absolute inset-0" @click="showModal = false"></div>

        <!-- Modal Content -->
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                Confirm Reservation
            </h3>
            <div class="mt-2">
                <p class="text-sm leading-5 text-gray-500">
                    Are you sure you want to reserve this item?
                </p>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click="reserve" type="button" @click="showModal = false" class="inline-flex justify-center w-full px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-400 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                       Reserve
                    </button>
                </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button type="button" @click="showModal = false" class="inline-flex justify-center w-full px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Cancel
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('reservationModal', () => ({
            showModal: false,
        }));

        window.Livewire.on('reservationMade', () => {
            alert('Your reservation has been confirmed!');
        });
    });
</script>
