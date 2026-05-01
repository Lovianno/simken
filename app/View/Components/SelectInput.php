<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectInput extends Component
{
    public $id;
    public $label;
    public $name;
    public $options;
    public $placeholder;
    public $disabled;
    public $dropdownClass;
    public $buttonClass;
    public $ulClass;
    public $selected;
    public $searchable;
    public $required;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $id = null,
        $label = null,
        $name = null,
        $options = [],
        $placeholder = null,
        $disabled = false,
        $dropdownClass = '',
        $buttonClass = '',
        $ulClass = '',
        $selected = null,
        $searchable = true,
        $required = false
    ) {
        // If id not provided, generate one from name (replace [] for arrays) or uniqid
        if (empty($id)) {
            if (!empty($name)) {
                $sanitized = str_replace(['[', ']'], ['_', ''], $name);
                $id = $sanitized . '_' . uniqid();
            } else {
                $id = 'select_' . uniqid();
            }
        }

        // If label not provided, derive from name
        if (empty($label) && !empty($name)) {
            $label = ucwords(str_replace(['_', '-'], ' ', str_replace(['[', ']'], '', $name)));
        }

        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->options = is_array($options) ? $options : (method_exists($options, 'toArray') ? $options->toArray() : $options);
        $this->placeholder = $placeholder;
        $this->disabled = $disabled;
        $this->dropdownClass = $dropdownClass;
        $this->buttonClass = $buttonClass;
        $this->ulClass = $ulClass;
        $this->selected = $selected;
        $this->searchable = $searchable;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-input');
    }
}
