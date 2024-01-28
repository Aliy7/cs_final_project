<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProfileComponent extends Component
{
    use WithFileUploads;
    public $username;
    public $email;
    public $first_name;
    public $last_name;
    public $bio;
    public $phone_number;
    public $date_of_birth;
    public $image_url;
    public $user;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:users,username,' . $this->user->id,
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before_or_equal:today',
            'image_url' => 'nullable|image|max:2048',
        ];
    }
    public function mount(): void
    {
        $this->user = Auth::user();
        $this->fill([
            'username' => $this->user->username,
            'email' => $this->user->email,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'bio' => $this->user->profile->bio ?? '',
            'phone_number' => $this->user->profile->phone_number ?? '',
            'date_of_birth' => $this->user->profile->date_of_birth ?? '',
        ]);
    }
    public function render()
    {
        return view('livewire.profile.profile-updating')
        ->layout('layouts.app');
    }

    public function save()
    {
        $this->validate();

        $this->user->update([
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ]);

        $profileData = [
            'bio' => $this->bio,
            'phone_number' => $this->phone_number,
            'date_of_birth' => $this->date_of_birth ? Carbon::createFromFormat('Y-m-d', $this->date_of_birth)->format('Y-m-d') : null,
        ];



        $this->user->profile()->updateOrCreate(['user_id' => $this->user->id], $profileData);
        session()->flash('success', 'User profile successfully updated.');
        $this->isEditing = false;
        $this->reset('image_url');
    }
    public function isEditingNow()
    {
        $this->isEditing = true;
    }

    public function notEditing()
    {
        $this->isEditing = false;
    }

    public function updateProfilePicture()
    {
        $this->validate([
            'image_url' => 'nullable|image|max:2048',
        ]);

        if ($this->image_url) {
            $imagePath = $this->profile_picture->store('avatars', 'public');
            Auth::user()->profile()->updateOrCreate([], ['profile_pic' => $imagePath]);
            $this->image_url = asset('storage/' . $imagePath);
        }

        session()->flash('message', 'Profile picture updated successfully.');
    }

}
