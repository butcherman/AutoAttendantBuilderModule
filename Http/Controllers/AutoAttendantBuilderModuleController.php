<?php

namespace Modules\AutoAttendantBuilderModule\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\AutoAttendantBuilderModule\Entities\CallFlowData;
use Modules\AutoAttendantBuilderModule\Http\Requests\FlowChartRequest;
use Illuminate\Support\Str;

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
            'ver'  => config('autoattendantbuildermodule.ver'),
        ]);
    }

    /**
     * Manually create the call flow tree
     */
    public function create()
    {
        return Inertia::render('AutoAttendantBuilderModule::Create', [
            'auth' => Auth::check() ? true : false,
            'ver'  => config('autoattendantbuildermodule.ver'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FlowChartRequest $request)
    {
        $newFlow = CallFlowData::create([
            'aa_link' => Str::uuid(),
            'aa_data' => (String) json_encode($request->node_data),
        ]);

        return redirect()->route('AutoAttendantBuilderModule.show', $newFlow->aa_link);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $nodeData = CallFlowData::where('aa_link', $id)->firstOrFail();

        return Inertia::render('AutoAttendantBuilderModule::Create', [
            'auth'      => Auth::check() ? true : false,
            'ver'       => config('autoattendantbuildermodule.ver'),
            'node_data' => json_decode($nodeData->aa_data),
            'aa_link'   => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $nodeData = CallFlowData::where('aa_link', $id)->firstOrFail();
        $nodeData->update([
            'aa_data' => (String) json_encode($request->node_data),
        ]);

        return redirect()->route('AutoAttendantBuilderModule.show', $nodeData->aa_link);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
