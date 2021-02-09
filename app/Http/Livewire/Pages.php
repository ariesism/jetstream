<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class Pages extends Component
{
    public $slug, $title, $content;
    public $modalFormVisible = false;
    
    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages');
    }
    
    /**
     * Shows the form modal
     * of the create function
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required',
        ];
    }
    
    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        Page::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetData();
    }
    
    /**
     * The data for the model mapped
     * in the component.
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content
        ];
    }
    
    /**
     * Reset the varables after creating data
     *
     * @return void
     */
    public function resetData()
    {
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }
}
