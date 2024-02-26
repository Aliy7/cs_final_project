
<section class="reservation-content  h-screen pt-20 pl-60 pr-4 pb-4">
   
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-md sm:rounded-lg">
                <table class=" table-responsive overflow-x-auto min-w-full divide-y divide-gray-200 text-center text-sm font-light">
                    <thead class="border-b bg-neutral-800 text-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Reserve Name</th>
                            <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Food Name</th>
                            <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Reservation Time</th>
                            <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Status</th>
                            @if(auth()->user()->hasRole('admin'))
                            <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-neutral-800">
                        @foreach ($reservations as $reservation)
                        <tr class="border-b dark:border-neutral-500">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $reservation->user->first_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $reservation->foodListing->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $reservation->created_at->format('m/d/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $reservation->status }}</td>
                            @if(auth()->user()->hasRole('admin'))
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <select wire:change="updateStatus({{ $reservation->id }}, $event.target.value)" class="text-sm rounded bg-white dark:bg-neutral-700 dark:text-white">
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
            </div>
        </div>
    </div>
</section>