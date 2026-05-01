<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Create a new component instance.
     */
     public $title;
    public $category;
    public $image;
    public $price;
    public $teacher;
    public $count;
    public $id;

    public $owned;


    public function __construct($title ="TITLE", $category = 'IT', $image = 'kemenag2.jpg', $price = 0, $teacher = "Teacher", $count = 0,$id = null, $owned = false)
    {
        $this->title = $title;
        $this->category = $category;
        $this->image = $image;
        $this->price = $price;
        $this->teacher = $teacher;
        $this->count = $count;
        $this->id = $id;
        $this->owned = $owned;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
