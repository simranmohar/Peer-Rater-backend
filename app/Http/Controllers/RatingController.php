<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::all();

        return response()->json($ratings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required',
            'category_id' => 'required',
            'peer_group_id' => 'required',
            'survey_id' => 'required',
            'rating' => 'required'
        ]);

        $user = Auth::user();

        $rating = new Rating;
        $rating->writer_id = $user->id;
        $rating->recipient_id = $request->input('recipient_id');
        $rating->category_id = $request->input('category_id');
        $rating->peer_group_id = $request->input('peer_group_id');
        $rating->survey_id = $request->input('survey_id');
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
    public function show(Rating $rating)
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
    public function update(Request $request, Rating $rating)
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
    public function destroy(Rating $rating)
    {
        $rating->delete();

        return response()->json([
            'message' => 'Successfully deleted rating!'
        ]);
    }
}
