<?php

namespace Modules\AutoAttendantBuilderModule\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class WizardController extends Controller
{
    /**
     * Show the Wizard landing page
     */
    public function index()
    {
        return Inertia::render('AutoAttendantBuilderModule::Wizard', [
            'auth' => Auth::check(),
        ]);
    }
}
