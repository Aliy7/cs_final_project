<div>
    <input id="textbox_id" type="text" wire:model.debounce.500ms="term" placeholder="Enter address term...">

    <script>
        getAddress.autocomplete('textbox_id', '3i9dKyvIlkWqvk6ehlZQew41674');
        document.addEventListener("getaddress-autocomplete-address-selected", function(e) {
            console.log("Address details received:", e.detail.address);

            @this.call('setAddressDetails', e.detail.address); // assuming e.detail.address is an object with the correct structure
        });
    </script>

    @if (!empty($selectedAddress))
        <div>
            <p>Selected Address: {{ implode(', ', $selectedAddress['formatted_address'] ?? []) }}</p>
            <input type="text" wire:model="selectedAddress.line_1" placeholder="Address Line 1">
            <input type="text" wire:model="selectedAddress.town_or_city" placeholder="Town/City">
            <input type="text" wire:model="selectedAddress.postcode" placeholder="Postcode">
            <!-- Include other fields as necessary -->
        </div>
    @endif
</div> 
{{-- <div wire:ignore>
    <label>Search Address</label>
    <input id="textbox_id" type="text"> 
</div>

@if (!empty($selectedAddress))
    <div>
        <label>First Address Line</label>
        <input type="text" wire:model="selectedAddress.line_1"> 
        
        <label>Second Address Line</label>
        <input type="text" wire:model="selectedAddress.line_2">   
        
        <label>Town</label>
        <input type="text" wire:model="selectedAddress.town">
        
        <label>County</label>
        <input type="text" wire:model="selectedAddress.county">
        
        <label>Postcode</label>
        <input type="text" wire:model="selectedAddress.postcode">
    </div>
@endif

{{-- <script src="https://cdn.getaddress.io/scripts/getaddress-autocomplete-1.1.3.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        getAddress.autocomplete('textbox_id', '3i9dKyvIlkWqvk6ehlZQew41674');

        document.addEventListener("getaddress-autocomplete-address-selected", function(e) {
            // Call a Livewire method to set the selected address details
            @this.call('setSelectedAddress', e.detail.address);
        });
    });
</script> --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        getAddress.autocomplete('textbox_id', '3i9dKyvIlkWqvk6ehlZQew41674');
    
        document.addEventListener("getaddress-autocomplete-address-selected", function(e) {
            const address = {
                line_1: e.detail.address.line_1 || '',
                line_2: e.detail.address.line_2 || '',
                town: e.detail.address.town || '',
                county: e.detail.address.county || '',
                postcode: e.detail.address.postcode || '',
            };
    
            // Use Livewire.emit to send the address data to the Livewire component
            Livewire.emit('setSelectedAddress', address);
        });
    });
    </script>
     --}} 