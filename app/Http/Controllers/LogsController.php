<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class LogsController extends Controller
{
    /**
     * Display the app settings form.
     * 
     * @pararm Request $request
     * 
     * @return View
     */
    public function view(Request $request): View
    {
        return view('logs-view');
    }

}
