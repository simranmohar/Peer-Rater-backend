<?php

namespace App\Http\Controllers;

use App\Models\PeerGroup;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/",
     *      operationId="Survey.index",
     *      tags={"Survey"},
     *      summary="get the Survey group by peerGroup id",
     *      description="Returns the Survey infomation as an array",
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
    public function index(PeerGroup $peerGroup)
    {
        $surveys = $peerGroup->surveys()->get();

        return response()->json($surveys);
    }    
    /**
     * @OA\Post(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/",
     *      operationId="Survey.store",
     *      tags={"Survey"},
     *      summary="create a Survey",
     *      description="create a new Survey by accepting peerGroup_id",
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
    public function store(Request $request, PeerGroup $peerGroup)
    {
        $survey = $peerGroup->surveys()->create($request->all());

        return response()->json([
            'message' => 'Great success! New survey created',
            'survey' => $survey
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/{survey_id}",
     *      operationId="Survey.show",
     *      tags={"Survey"},
     *      summary="show a Survey infomation",
     *      description="show a new Survey by accepting peerGroup_id and survey_id",
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
     *          description="Success operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    public function show(PeerGroup $peerGroup, Survey $survey)
    {
        return $survey;
    }

    /**
     * @OA\Put(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/{survey_id}",
     *      operationId="Survey.update",
     *      tags={"Survey"},
     *      summary="update a Survey infomation",
     *      description="update a new Survey by accepting peerGroup_id, survey_id and a new peer_group_id",
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="current peerGroup ID",
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
     *         name="peer_group_id",
     *         in="path",
     *         description="updated peerGroup ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
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
    public function update(Request $request, PeerGroup $peerGroup, Survey $survey)
    {
        $survey->update($request->all());

        return response()->json([
            'message' => 'Great success! Survey updated',
            'survey' => $survey
        ]);
    }

    /**
     * @OA\Delete(
     *      path="/api/peer-groups/{peerGroup_id}/surveys/{survey_id}",
     *      operationId="Survey.destroy",
     *      tags={"Survey"},
     *      summary="delete a Survey infomation",
     *      description="delete a new Survey by accepting peerGroup_id, survey_id",
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="current peerGroup ID",
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
     *          description="Success operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    public function destroy(PeerGroup $peerGroup, Survey $survey)
    {
        $survey->delete();

        return response()->json([
            'message' => 'Successfully deleted survey!'
        ]);
    }
}
