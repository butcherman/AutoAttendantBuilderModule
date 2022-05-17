<?php

namespace Modules\AutoAttendantBuilderModule\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AutoAttendantBuilderModuleController extends Controller
{
    public function __construct()
    {
        if(!config('autoattendantbuilder.allow_public_access'))
        {
            $this->middleware('auth');
        }
    }

    /**
     * Landing page for the Module
     */
    public function index()
    {
        return Inertia::render('AutoAttendantBuilderModule::Index', [
            'auth' => Auth::check() ? true : false,
        ]);
    }
}
