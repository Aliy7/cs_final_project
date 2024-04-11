
<div class="pt-16 pl-60 pb-10 min-h-screen bg-gray-100 profile-show">
    <div class="container mx-auto max-w-4xl p-5 bg-white rounded-lg shadow-lg">
        @if($profile && $profile->user)
            <div class="text-xl font-semibold mb-4">User Profile: {{ $profile->user->username }}</div>
            
            <div class="mb-3">
                <strong>First Name:</strong> {{ $profile->user->first_name }}
            </div>
            <div class="mb-3">
                <strong>Last Name:</strong> {{ $profile->user->last_name }}
            </div>
            <div class="mb-3">
                <strong>Email:</strong> {{ $profile->user->email }}
            </div>
            <div class="mb-3">
                <strong>Bio:</strong> {{ $profile->bio ?? 'N/A' }}
            </div>
            <div class="mb-3">
                <strong>Phone Number:</strong> {{ $profile->phone_number ?? 'N/A' }}
            </div>
            <div class="mb-3">
                <strong>Date of Birth:</strong> {{ $profile->date_of_birth ? \Carbon\Carbon::parse($profile->date_of_birth)->format('Y-m-d') : 'N/A' }}
            </div>
            
            
            <div class="mb-3">
                <strong>Image:</strong>
                @if($profile->image_url)
                    <div><img src="{{ $profile->image_url }}" alt="Profile Image" class="w-24 h-24 rounded-lg shadow"></div>
                @else
                    <div class="w-24 h-24 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                @endif
            </div>
        @else
        <div class="text-center text-gray-700">This user does not have a profile yet.</div>
        @endif
    </div>
</div>
