<?php

namespace App\Livewire\HelpPage;

use Livewire\Component;
use App\Models\HelpContent;
use Illuminate\Support\Facades\Auth;

class HelpContentManager extends Component
{
    public $title;
    public $content;
    public $category;

    public function render()
    {
        return view('livewire.help-page.help-content-manager')
            ->layout('livewire.app.app-layout');
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:3000',
            'category' => 'required|string|max:255',
        ]);

        if (!Auth::check()) {
            return;
        }
        $helpContent = new HelpContent;
        $helpContent->title = $this->title;
        $helpContent->content = $this->content;
        $helpContent->category = $this->category;
        $helpContent->user_id = Auth::id(); 
        $helpContent->save();

        session()->flash('message', 'Help content added successfully.');
        $this->reset(['title', 'content', 'category']);
    }

  
}
