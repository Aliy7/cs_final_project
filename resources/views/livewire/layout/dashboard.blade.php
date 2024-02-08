    {{-- <x-app-layout> --}}

        {{--dashboard.blade.php--}}
        <section class="dashboard-content">
            {{-- <x-slot name="header">
                {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2> --}}
            {{-- </x-slot> --}}
        
            <div class="py-9">
                <div class="max-w-10xl mx-auto sm:px-6 lg:px-12">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{-- {{ __("You're logged in!") }} --}}
                            {{-- @livewire('geo-code-post-code.location')  --}}
                            {{-- @livewire('location.location-search') --}}

                            {{-- @livewire('foodlisting.create-food-listing')

                            @livewire('foodlisting.show-food-listing')  --}}

<!-- First Block for Creating Food Listing -->
<div class="block create-food-listing">
    @livewire('foodlisting.create-food-listing')
</div>

<!-- Second Block for Showing Food Listing -->
<div class="block show-food-listing">
    @livewire('foodlisting.show-food-listing')
</div> 

                        </div>
                    </div>
                </div>
            </div>
           
        </section>
        
        {{-- </x-app-layout> --}}