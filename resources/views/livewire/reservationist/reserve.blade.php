<div>
    <div>
        <!-- Start of Table -->
        <table class="min-w-full divide-y divide-gray-200">
            <h1> Hello</h1>
            <thead>
                <tr class="bg-gray-50">
                    <!-- Table Headers -->
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Reserver
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Food Item
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Reservation Time
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    @if(auth()->user()->hasRole('admin'))
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Table Content -->
                @foreach ($reservations as $reservation)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $reservation->user->first_name }}
    
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $reservation->foodListing->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $reservation->created_at->format('m/d/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $reservation->status }}
                    </td>
                    @if(auth()->user()->hasRole('admin'))
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <select wire:change="updateStatus({{ $reservation->id }}, $event.target.value)" class="text-sm rounded">
                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $reservation->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        <    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
</div>
