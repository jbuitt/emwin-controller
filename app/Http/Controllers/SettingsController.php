<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Product;

class SettingsController extends Controller
{
    /**
     * Display the app settings form.
     */
    public function edit(Request $request): View
    {
        return view('settings.edit');
    }

    /**
     * Update the app's settings.
     */
    public function update(Request $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());

        // If request to purge all products, do that noew
        if ($request->input('type') === 'purge_all_products') {
            Product::truncate();
            if (!is_null(config('emwin-controller.emwin.archivedir')) && !empty(config('emwin-controller.emwin.archivedir'))) {
                chdir(storage_path(config('emwin-controller.emwin.archivedir')));
                exec('rm -rf *');
            }
            return Redirect::route('dashboard');
        }
        return Redirect::route('settings.edit')->with('status', 'settings-updated');
    }

}
