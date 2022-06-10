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
        return Inertia::render('AutoAttendantBuilderModule::Index', [
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
        // return $request;

        return Inertia::render('AutoAttendantBuilderModule::Show', [
            'auth' => Auth::check() ? true : false,
            'loadedNodes' => $request,
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = '[{"id":0,"parentId":-1,"nodeComponent":"incoming-lines","data":{"headerText":"Start Here","lineList":["(530) 223-2979"]},"valid":true,"active":false,"hasChildren":true},{"id":1,"parentId":0,"nodeComponent":"schedule","data":{"headerText":"Business Hours","schedule":[{"start_time":"08:00","stop_time":"17:00","days":["mon","tue","wed","thu","fri"]}]},"valid":true,"active":false,"hasChildren":true},{"id":2,"parentId":1,"nodeComponent":"greeting","data":{"headerText":"On Hours Greeting","greeting":"Hello and thank you for calling ABC Company.  If you know the extension number\n                            of the person you are trying to reach, you may enter it at any time.  Press 8\n                            for a staff directory, or stay on the line to leave a general message.","availableOptions":[0,1,2,3,4,5,6,7,9]},"valid":true,"active":false,"hasChildren":true},{"id":3,"parentId":1,"nodeComponent":"greeting","data":{"headerText":"Off Hours Greeting","greeting":"Hello and thank you for calling ABC Company.  If you know the extension number\n                            of the person you are trying to reach, you may enter it at any time.  Press 8\n                            for a staff directory, or stay on the line to leave a general message.","availableOptions":[0,1,2,3,4,5,6,7,9]},"valid":true,"active":true,"hasChildren":true},{"id":4,"parentId":2,"nodeComponent":"dialOption","data":{"num":11,"verbage":"Time Out","whatHappens":null,"availableOptions":[0,1,2,3,4,5,6,7,9],"targetExtension":[]},"valid":false,"active":false,"hasChildren":false},{"id":5,"parentId":2,"nodeComponent":"dialOption","data":{"num":8,"verbage":"Press","whatHappens":null,"availableOptions":[0,1,2,3,4,5,6,7,9],"targetExtension":[]},"valid":false,"active":false,"hasChildren":false},{"id":6,"parentId":3,"nodeComponent":"dialOption","data":{"num":11,"verbage":"Time Out","whatHappens":null,"availableOptions":[0,1,2,3,4,5,6,7,9],"targetExtension":[]},"valid":false,"active":false,"hasChildren":false},{"id":7,"parentId":3,"nodeComponent":"dialOption","data":{"num":8,"verbage":"Press","whatHappens":null,"availableOptions":[0,1,2,3,4,5,6,7,9],"targetExtension":[]},"valid":false,"active":false,"hasChildren":false}]';



        return Inertia::render('AutoAttendantBuilderModule::Show', [
            'auth' => Auth::check() ? true : false,
            'loadedNodes' => $data,
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
