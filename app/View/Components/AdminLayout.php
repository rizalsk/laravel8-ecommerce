<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    public $nav = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($nav)
    {
        $this->nav = $nav;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.admin.base');
    }
}
