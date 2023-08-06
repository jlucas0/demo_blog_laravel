<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Adapters\Adapter;

class Pagination extends Component
{

    public int $page;
    public int $pages;
    /**
     * Create a new component instance.
     * @param string $adapter Elements adapter class to be used
     * @param int $page Current page
     * @param int $perPage Number of elements per page
     */
    public function __construct(string $adapter, int $page,int $perPage)
    {
        $this->page = $page;
        $amount = $adapter::getCount();
        
        $this->pages = (int)ceil($amount/$perPage);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pagination');
    }
}
