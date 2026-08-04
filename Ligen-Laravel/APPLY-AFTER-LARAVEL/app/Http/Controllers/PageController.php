<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show a static page by slug (e.g. about-us, contact, electric-cycle).
     */
    public function show(Request $request): View
    {
        $slug = $request->route('slug', 'index');

        $view = 'pages.' . $slug;

        if (!view()->exists($view)) {
            abort(404, 'Page not found');
        }

        return view($view);
    }
}
