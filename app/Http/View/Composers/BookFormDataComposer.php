<?php

namespace App\Http\View\Composers;

use App\Models\Author;
use App\Models\Category;
use Illuminate\View\View;

class BookFormDataComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'authors' => Author::all(),
            'categories' => Category::all(),
        ]);
    }
} 