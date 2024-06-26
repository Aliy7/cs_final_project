<?php

namespace App\Livewire\HelpPage;

use Livewire\Component;
use App\Models\HelpContent;

class ShowHelpContent extends Component
{

    public $FAQContents;
    public $editingContent = false;
    public $editTitle;
    public $editContent;
    public $editCategory;
    public $editId;
    /**
     * Mount the component and initialize properties.
     *
     * This method fetches all the help contents available and assigns them
     * to the FAQContents property when the component is initialized.
     */
    public function mount()
    {
        $this->FAQContents = HelpContent::all();
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View The view instance with layout.
     */
    public function render()
    {
        return view('livewire.help-page.show-help-content')
            ->layout('livewire.app.app-layout');
    }

    /**
     * Initiate editing of a specific help content item.
     *
     * @param int $id The ID of the help content to edit.
     */
    public function edit($id)
    {
        $helpContent = HelpContent::findOrFail($id);
        $this->editTitle = $helpContent->title;
        $this->editContent = $helpContent->content;
        $this->editCategory = $helpContent->category;
        $this->editId = $id;
        $this->editingContent = true;
    }

    /**
     * Update the currently edited help content in the database.
     *
     * This method validates and updates the help content being edited. After updating,
     * it resets the editing state and refreshes the list of FAQ contents.
     */
    public function update()
    {
        $validatedData = $this->validate([
            'editTitle' => 'required|string|max:255',
            'editContent' => 'required|string',
            'editCategory' => 'required|string',
        ]);

        $helpContent = HelpContent::findOrFail($this->editId);
        $helpContent->update([
            'title' => $this->editTitle,
            'content' => $this->editContent,
            'category' => $this->editCategory,
        ]);

        $this->editingContent = false;
        $this->mount();
        $this->dispatch('FAQEdited');
    }

    /**
     * Cancel the editing process and reset related properties.
     *
     * This method resets the editing state and clears all properties related to the
     * content being edited.
     */
    public function cancel()
    {
        $this->editingContent = false;
        $this->reset(['editTitle', 'editContent', 'editCategory', 'editId']);
    }
}
