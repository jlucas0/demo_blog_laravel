<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use App\Adapters\PostAdapter;

class Recents extends Component
{

    public Collection $posts;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->posts = PostAdapter::getList(3,0,'created_at',false);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recents');
    }
}
