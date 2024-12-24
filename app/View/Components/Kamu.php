<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Kamu extends Component
{
    public $text;
    public $href;
    public $xUrl;
    public $websiteUrl;
    public $instagramUrl;
    public $linkedinUrl;

    public function __construct($text, $href, $websiteUrl = "dwqdqw", $xUrl, $instagramUrl, $linkedinUrl)
    {
        $this->text = $text;
        $this->href = $href;
        $this->xUrl = $xUrl;
        $this->websiteUrl = $websiteUrl;
        $this->instagramUrl = $instagramUrl;
        $this->linkedinUrl = $linkedinUrl;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kamu');
    }
}
