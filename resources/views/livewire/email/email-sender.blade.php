<!-- resources/views/livewire/email-sender.blade.php -->
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 email-content">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form wire:submit.prevent="sendEmail" class="space-y-4">
                      
                        <div>
                            <input type="text" wire:model.defer="subject" placeholder="Subject" class="input bg-gray-100 w-full rounded border shadow p-2 mr-2 my-2">
                            <div>@error('subject')<span class="text-red-500">{{ $message }}</span>@enderror</div>
                        </div>
                        <div>
                            <textarea wire:model.defer="body" placeholder="Message body" class="input bg-gray-100 w-full rounded border shadow p-2 mr-2 my-2"></textarea>
                            <div>@error('body')<span class="text-red-500">{{ $message }}</span>@enderror</div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded text-white">Send Email</button>
                        </div>
                    </form>
                    @if (session()->has('message'))
                        <div class="mt-3 text-green-500">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>        