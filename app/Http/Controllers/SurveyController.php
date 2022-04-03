<?php

namespace App\Http\Controllers;

use App\Models\PeerGroup;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\PeerGroup  $peerGroup
     * @return \Illuminate\Http\Response
     */
    public function index(PeerGroup $peerGroup)
    {
        $surveys = $peerGroup->surveys()->get();

        return response()->json($surveys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PeerGroup  $peerGroup
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PeerGroup $peerGroup)
    {
        $survey = $peerGroup->surveys()->create($request->all());

        return response()->json([
            'message' => 'Great success! New survey created',
            'survey' => $survey
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PeerGroup  $peerGroup
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(PeerGroup $peerGroup, Survey $survey)
    {
        return $survey;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PeerGroup  $peerGroup
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PeerGroup $peerGroup, Survey $survey)
    {
        $survey->update($request->all());

        return response()->json([
            'message' => 'Great success! Survey updated',
            'survey' => $survey
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PeerGroup  $peerGroup
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(PeerGroup $peerGroup, Survey $survey)
    {
        $survey->delete();

        return response()->json([
            'message' => 'Successfully deleted survey!'
        ]);
    }
}
