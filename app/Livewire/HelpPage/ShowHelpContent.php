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


    public function mount(){
        $this->FAQContents = HelpContent::all();
    }
    public function render()
    {
        return view('livewire.help-page.show-help-content')
        ->layout('livewire.app.app-layout');
    }

    public function edit($id) {
        $helpContent = HelpContent::findOrFail($id);
        $this->editTitle = $helpContent->title;
        $this->editContent = $helpContent->content;
        $this->editCategory = $helpContent->category;
        $this->editId = $id;
        $this->editingContent = true;
    }

    public function update() {
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
        $this -> dispatch('FAQEdited');
    }

    public function cancel() {
        $this->editingContent = false;
        $this->reset(['editTitle', 'editContent', 'editCategory', 'editId']);
    }
    
    
    
}
