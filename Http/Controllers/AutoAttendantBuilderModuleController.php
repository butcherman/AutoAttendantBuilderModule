<?php

namespace Modules\AutoAttendantBuilderModule\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
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
     * Landing page for the AA Builder Module
     */
    public function index()
    {
        return Inertia::render('AutoAttendantBuilderModule::Create', [
            'auth' => Auth::check() ? true : false,
        ]);
    }

    /**
     * Manually create the call flow tree
     */
    public function create()
    {
        return Inertia::render('AutoAttendantBuilderModule::Create', [
            'auth' => Auth::check() ? true : false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return Inertia::render('AutoAttendantBuilderModule::Create', [
            'auth' => Auth::check() ? true : false,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return Inertia::render('AutoAttendantBuilderModule::Index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
