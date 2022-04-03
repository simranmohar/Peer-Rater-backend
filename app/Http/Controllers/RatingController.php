<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;
use App\Models\PeerGroup;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PeerGroup $peerGroup, Survey $survey)
    {
        $ratings = $survey->ratings()->get();

        return response()->json($ratings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PeerGroup $peerGroup, Survey $survey)
    {
        $request->validate([
            'recipient_id' => 'required',
            'category_id' => 'required',
            'rating' => 'required'
        ]);

        $user = Auth::user();

        $rating = new Rating;
        $rating->writer_id = $user->id;
        $rating->recipient_id = $request->input('recipient_id');
        $rating->category_id = $request->input('category_id');
        $rating->peer_group_id = $peerGroup->id;
        $rating->survey_id = $survey->id;
        $rating->rating = $request->input('rating');

        $rating->save();

        return response()->json([
            'message' => 'Great success! New rating created',
            'rating' => $rating
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(PeerGroup $peerGroup, Survey $survey, Rating $rating)
    {
        return $rating;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PeerGroup $peerGroup, Survey $survey, Rating $rating)
    {
        $request->validate([
            'recipient' => 'nullable',
            'category_id' => 'nullable',
            'peer_group_id' => 'nullable',
            'survey_id' => 'nullable',
            'rating' => 'nullable'
        ]);

        $rating->update($request->all());

        return response()->json([
            'message' => 'Great success! Rating updated',
            'rating' => $rating
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(PeerGroup $peerGroup, Survey $survey, Rating $rating)
    {
        $rating->delete();

        return response()->json([
            'message' => 'Successfully deleted rating!'
        ]);
    }
}
