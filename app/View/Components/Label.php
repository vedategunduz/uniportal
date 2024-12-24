<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    public $for;
    public $class = "block mb-2 text-sm font-medium text-zinc-900";
    public $text;
    /**
     * Create a new component instance.
     */
    public function __construct($for = null, $text)
    {
        $this->for = $for;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.label');
    }
}
