{{-- dashboard.blade.php --}}
<section class="dashboard-content">
    <div class="py-9">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- First Block for Creating Food Listing -->
                    @if (auth()->user() && auth()->user()->hasRole('admin'))
                        <div class="block create-food-listing">
                            @livewire('foodlisting.create-food-listing')
                        </div>
                    @endif
                    <!-- Second Block for Showing Food Listing -->
                    <div class="block show-food-listing">
                        @livewire('foodlisting.show-food-listing')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

