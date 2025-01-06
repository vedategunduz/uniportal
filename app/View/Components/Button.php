<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $id;
    public $text;
    public $type;
    public $class = "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center";

    public function __construct($id = '', $text, $type = 'button')
    {
        $this->id   = $id;
        $this->text = $text;
        $this->type = $type;
    }

      /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
