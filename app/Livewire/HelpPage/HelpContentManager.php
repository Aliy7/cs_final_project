<?php

namespace App\Livewire\HelpPage;

use Livewire\Component;
use App\Models\HelpContent;
use Illuminate\Support\Facades\Auth;

/**
 * Manages help content for the application, facilitating the creation, viewing, and updating of help articles.
 * 
 * This Livewire component handles validation and storage of help content in the database, ensuring operations
 * It provides a dynamic and responsive interface for managing help articles,
 * including immediate feedback on user interactions.
 */

class HelpContentManager extends Component
{
    public $title;
    public $content;
    public $category;
    public $helpContent;

    /**
     * Render the component view.
     * This function renders the component's view and applies the layout.
     * 
     * @return \Illuminate\View\View The view for managing help content.
     */
    public function render()
    {
        return view('livewire.help-page.help-content-manager')
            ->layout('livewire.app.app-layout');
    }

    /**
     * Save new help content to the database.
     * This function validates the input fields and saves new help content to the database.
     * 
     * @return void
     */
    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:3000',
            'category' => 'required|string|max:255',
        ]);

        // Check if the user is authenticated.
        if (!Auth::check()) {
            return;
        }

        // Create a new instance of HelpContent model and save it to the database.
        $helpContent = new HelpContent;
        $helpContent->title = $this->title;
        $helpContent->content = $this->content;
        $helpContent->category = $this->category;
        $helpContent->user_id = Auth::id();
        $helpContent->save();

        session()->flash('message', 'Help content added successfully.');
        $this->reset(['title', 'content', 'category']);
        $this->helpContent = HelpContent::all();
    }

    /**
     * Initialize the component with initial data.
     * This function initializes the component with the initial data.
     * It retrieves all existing help content items from the database.
     * @return void
     */
    public function mount()
    {
        $this->helpContent = HelpContent::all();
    }
}
