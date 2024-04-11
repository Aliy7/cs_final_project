 <section class=" profile-content bg-white dark:bg-gray-900">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
        <div class="contanctus-content mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mx-auto max-w-lg">
          <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Contact Us</h2>
          <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">
              Get in touch with us.
          </p>
            <form wire:submit.prevent="submitForm" class="space-y-8">
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email below</label>
                    <input wire:model.defer="email" type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="name@example.com" required>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name </label>
                    <input wire:model.defer="name" type="text" id="name" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder=" Enter Name here ..." required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Your message</label>
                    <textarea wire:model.defer="message" id="message" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Email Content here..."></textarea>
                    @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class=" py-3 px-5 focus:outline-none text-white bg-purple-700 hover:bg-green-700 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Submit Form</button>

              
            </form>
        </div>
    </div>
</section>
