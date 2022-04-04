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
     * @OA\Get(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/{survey_id}/ratings",
     *      operationId="ratings.index",
     *      tags={"Rating"},
     *      summary="get the rating group infomation by peerGroup id and survey id",
     *      description="Returns the rating infomation",
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peerGroup ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="survey_id",
     *         in="path",
     *         description="survey ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *       @OA\Response(
     *          response=200,
     *          description="User not exsits! / Success, User is detached from peer group / Error, User does not exsit in peer group",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    public function index(PeerGroup $peerGroup, Survey $survey)
    {
        $ratings = $survey->ratings()->get();

        return response()->json($ratings);
    }

    /**
     * @OA\Post(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/{survey_id}/ratings",
     *      operationId="ratings.store",
     *      tags={"Rating"},
     *      summary="create a rating",
     *      description="create a new rating by accepting rating content, return the new rating information",
     *      @OA\Parameter(
     *         name="recipient_id",
     *         in="path",
     *         description="recipient ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="survey_id",
     *         in="path",
     *         description="survey ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="category_id",
     *         in="path",
     *         description="category ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peerGroup ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="rating",
     *         in="path",
     *         description="rating content",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *       @OA\Response(
     *          response=200,
     *          description="Success operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
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
     * @OA\Get(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/{survey_id}/ratings/{rating_id}",
     *      operationId="ratings.show",
     *      tags={"Rating"},
     *      summary="get a rating infomation",
     *      description="(Not Confirm) Returns the rating infomation by rating id, survey id and peerGroup id",
     *      @OA\Parameter(
     *         name="survey_id",
     *         in="path",
     *         description="survey ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peerGroup ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="rating_id",
     *         in="path",
     *         description="This is the rating ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     * 
     *       @OA\Response(
     *          response=200,
     *          description="Success operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    public function show(PeerGroup $peerGroup, Survey $survey, Rating $rating)
    {
        return $rating;
    }

    /**
     * @OA\Put(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/{survey_id}/ratings/{rating_id}",
     *      operationId="ratings.update",
     *      tags={"Rating"},
     *      summary="update a rating",
     *      description="Update the rating infomation by rating id, survey id and peerGroup id",
     *      @OA\Parameter(
     *         name="survey_id",
     *         in="path",
     *         description="survey ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peerGroup ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="rating_id",
     *         in="path",
     *         description="rating ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="rating",
     *         in="path",
     *         description="rating content",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      
     *       @OA\Response(
     *          response=200,
     *          description="Success operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
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
     * @OA\Delete(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/{survey_id}/ratings/{rating_id}",
     *      operationId="ratings.destroy",
     *      tags={"Rating"},
     *      summary="delete a rating",
     *      description="delete the rating by rating id, survey id and peerGroup id",
     *      @OA\Parameter(
     *         name="survey_id",
     *         in="path",
     *         description="survey ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peerGroup ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="rating_id",
     *         in="path",
     *         description="rating ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      
     *       @OA\Response(
     *          response=200,
     *          description="Success operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    public function destroy(PeerGroup $peerGroup, Survey $survey, Rating $rating)
    {
        $rating->delete();

        return response()->json([
            'message' => 'Successfully deleted rating!'
        ]);
    }
}
