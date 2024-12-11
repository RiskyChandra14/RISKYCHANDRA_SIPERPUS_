<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchForm extends Component
{
    public $query;

    public function __construct($query = null)
    {

        $this->query = $query;
    }

    public function render()
    {
        return view('components.search-form');
    }
}