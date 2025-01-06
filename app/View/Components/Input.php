<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $id;
    public $type;
    public $name;
    public $value;
    public $class = "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5";
    public $placeholder;

    public function __construct($id = null, $type = null, $name = null, $value = null, $placeholder = null)
    {
        $this->id          = $id;
        $this->type        = $type;
        $this->name        = $name;
        $this->value       = $value;
        $this->placeholder = $placeholder;
    }

      /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
