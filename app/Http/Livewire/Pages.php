<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Pages extends Component
{
    public $slug, $title, $content, $modelId;
    public $modalFormVisible = false;
    
    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages', [
            'data' => $this->read()
        ]);
    }

    public function read()
    {
        return Page::paginate(5);
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
    
    /**
     * Shows the form modal
     * of the update function
     *
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }
    
    /**
     * Load the model data
     * of this component
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Page::find($this->modelId);
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->content = $data->content;
    }

    /**
     * The validatioin rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')],
            'content' => 'required'
        ];
    }
    
    /**
     * Run everytime the title
     * variable is updated
     *
     * @return void
     */
    public function updatedTitle($value)
    {
        $this->generateSlug($value);
    }
    
    /**
     * Generate a url slug
     * based on the title.
     *
     * @param  mixed $value
     * @return void
     */
    private function generateSlug($value)
    {
        $process1 = str_replace(' ', '-', $value);
        $process2 = strtolower($process1);
        $this->slug = $process2;
    }
    
    public function create()
    {
        $this->validate();

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

    public function resetData()
    {
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }
}
