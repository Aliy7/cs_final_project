<section class="application-display-content h-screen pt-20 pl-60 pr-4 pb-4">

    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-md sm:rounded-lg">
            <table class="table-responsive overflow-x-auto min-w-full divide-y divide-gray-200 text-center text-sm font-light">
                <thead class="border-b bg-neutral-800 text-white">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">No.</th>
                        <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Applicant Name</th>
                        <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Income</th>
                        <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Submitted At</th>
                        @if(auth()->user()->hasRole('admin'))
                <th scope="col" class="px-6 py-4 text-xs font-medium uppercase tracking-wider">Actions</th>
                @endif
                    </tr>
                </thead>
                <thead>
                    <!-- ... your thead content ... -->
                </thead>
                <tbody class="bg-white dark:bg-neutral-800">
                    @foreach ($applications as $application)
                        <tr class="border-b dark:border-neutral-500">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $loop->index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $application->user->first_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $application->family_income }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $application->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $application->created_at->format('Y-m-d H:i:s') }}</td>
                            @if(auth()->user()->hasRole('admin'))
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <select wire:change="updateStatus({{ $application->id }}, $event.target.value)" class="text-sm rounded bg-white dark:bg-neutral-700 dark:text-white">
                                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="denied" {{ $application->status == 'denied' ? 'selected' : '' }}>Denied</option>
                                </select>
                            </td>
                        @endif
                        
                        </tr>
                    @endforeach
                </tbody>
                
                
            </table>
        </div>
    </div>
</section>
