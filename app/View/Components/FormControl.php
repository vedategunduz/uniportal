<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormControl extends Component
{
    public $id;
    public $for;
    public $type;
    public $name;
    public $text;

    public function __construct($for, $type, $id, $name, $text)
    {
        $this->id = $id;
        $this->for = $for;
        $this->type = $type;
        $this->name = $name;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-control');
    }
}
