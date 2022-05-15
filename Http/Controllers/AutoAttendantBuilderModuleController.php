<?php

namespace Modules\AutoAttendantBuilderModule\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AutoAttendantBuilderModuleController extends Controller
{
    public function __construct()
    {
        //  Add the Auth middleware if public users are not allowed to access this tool
        if(!config('autoattendantbuildermodule.allow_public_access'))
        {
            $this->middleware('auth');
        }
    }

    /**
     * Initial landing page to build application
     */
    public function index()
    {
        return Inertia::render('AutoAttendantBuilderModule::Index', [
            'auth' => Auth::check() ? true : false,
        ]);
    }
}
