<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InformationBox extends Component
{
    public $id;
    public $name;
    public $image;
    public $updatedAt;
    public $value;
    public $metric;
    public $actions;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $name, $image, $value, $metric, $updatedAt, $actions)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->updatedAt = $updatedAt;
        $this->value = $value;
        $this->metric = $metric;
        $this->actions = $actions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.information-box');
    }
}
