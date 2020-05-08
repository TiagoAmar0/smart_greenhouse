<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InformationBox extends Component
{
    public $name;
    public $image;
    public $updatedAt;
    public $value;
    public $metric;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $image, $value, $metric, $updatedAt)
    {
        $this->name = $name;
        $this->image = $image;
        $this->updatedAt = $updatedAt;
        $this->value = $value;
        $this->metric = $metric;
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
