<div class="profile-content">
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
            <h2 class="mb-8 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Frequently Asked Questions</h2>
            <div class="text-left border-t border-gray-200 dark:border-gray-700">
                @foreach ($FAQContents as $content)
                    <div class="border-b-4 border-blue-500 py-6">
                        {{-- Display Mode --}}
                        @if(!$editingContent || $editId != $content->id)
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    <span class="text-gray-500 dark:text-gray-400 mr-2">{{ $content->category }}</span>
                                    {{ $content->title }}
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400">{{ $content->content }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    Posted by {{ optional($content->user)->username ?? 'Unknown' }} on {{ $content->created_at->format('M d, Y') }}
                                </span>
                                <button wire:click="edit({{ $content->id }})" class="bg-blue-500 text-white px-2 py-1">Edit</button>
                            </div>
                        @endif
                        {{-- Edit Mode --}}
                        @if($editingContent && $editId == $content->id)
                            <div>
                                <input wire:model.defer="editTitle" class="form-input mt-2 block w-full" placeholder="Title">
                                <textarea wire:model.defer="editContent" class="form-textarea mt-1 block w-full" rows="4" placeholder="Description"></textarea>
                                <input wire:model.defer="editCategory" class="form-input mt-2 block w-full" placeholder="Category">
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    Posted by {{ optional($content->user)->username ?? 'Unknown' }} on {{ $content->created_at->format('M d, Y') }}
                                </span>
                                <div>
                                    <button wire:click="update" class="bg-green-500 text-white px-2 py-1">Save</button>
                                    <button wire:click="cancel" class="bg-red-500 text-white px-2 py-1">Cancel</button>
                                </div>
                            </div>
                            @error('editContent') <span class="error text-red-500 text-xs">{{ $message }}</span> @enderror
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
