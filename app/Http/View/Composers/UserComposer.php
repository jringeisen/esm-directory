<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class UserComposer
{
    /**
     * Create a new profile composer.
     *
     * @param
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container..
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('user', auth()->user())
            ->with('role', auth()->user() ? auth()->user()->roles[0]->name : []);
    }
}
