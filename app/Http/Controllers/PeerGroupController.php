<?php

namespace App\Http\Controllers;

use App\Models\PeerGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeerGroupController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/peer-groups",
     * operationId="index",
     *      tags={"PeerGroup"},
     *      summary="get the peerGroups for the login user",
     *      description="Return a peer-group array",
     *      @OA\Parameter(
     *          name="description",
     *          description="peer group description",
     *          required=true,
     *          example="New Peer Group 1",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */    
    public function index()
    {
        $user = Auth::user();
        $peerGroups = $user->peerGroups()->get();

        return response()->json($peerGroups);
    }

    /**
     * @OA\Post(
     *      path="/api/peer-groups",
     *      operationId="store",
     *      tags={"PeerGroup"},
     *      summary="create a new peerGroup and add the current login user",
     *      description="Return a peer-group array",
     *      @OA\Parameter(
     *          name="description",
     *          description="peer group description",
     *          required=true,
     *          example="New Peer Group 1",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    //     {
    //     "message": "Great success! New peer group created",
    //     "peerGroup": {
    //         "user_id": 11,
    //         "description": "peerGroup12",
    //         "updated_at": "2022-04-04T03:02:29.000000Z",
    //         "created_at": "2022-04-04T03:02:29.000000Z",
    //         "id": 68
    //     }
    // }

    
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $user = Auth::user();

        $peerGroup = new PeerGroup;
        $peerGroup->user_id = $user->id;
        $peerGroup->description = $request->input('description');

        $peerGroup->save();

        $peerGroup->users()->attach($user);

        return response()->json([
            'message' => 'Great success! New peer group created',
            'peerGroup' => $peerGroup
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/peer-groups/{peerGroup_id}",
     *      operationId="show",
     *      tags={"PeerGroup"},
     *      summary="get the peerGroup infomation by the id in the path",
     *      description="Returns the peer group infomation",
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peerGroup ID in path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */   
    public function show(PeerGroup $peerGroup)
    {
        return $peerGroup;
    }

    /**
     * @OA\Put(
     *      path="/api/peer-groups/{peerGroup_id}",
     *      operationId="update",
     *      tags={"PeerGroup"},
     *      summary="update the peerGroup infomation",
     *      description="Return the updated peer-group infomation",
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peerGroup ID in path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="updated peerGroup desciption",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */   
    public function update(Request $request, PeerGroup $peerGroup)
    {
        $request->validate([
           'description' => 'nullable'
        ]);

        $peerGroup->update($request->all());

        return response()->json([
            'message' => 'Great success! Peer group updated',
            'peerGroup' => $peerGroup
        ]);
    }

    /**
     * @OA\Delete(
     *      path="/api/peer-groups/{peerGroup_id}",
     *      operationId="destroy",
     *      tags={"PeerGroup"},
     *      summary="delete the peerGroup by peerGroup ID",
     *      description="Returns the peer group infomation",
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peerGroup ID in path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    public function destroy(PeerGroup $peerGroup)
    {
        $user = Auth::user();

        $peerGroup->users()->detach($user);

        $peerGroup->delete();

        return response()->json([
            'message' => 'Successfully deleted peer group!'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/peer-groups/{peerGroup_id}/attach",
     *      operationId="attach",
     *      tags={"PeerGroup"},
     *      summary="add a user to a peerGroup by user ID",
     *      description="Returns the peer group infomation",
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peer-group ID for attachingh the user in path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="user ID to attach",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *       @OA\Response(
     *          response=200,
     *          description="successful operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     */
    public function attach(Request $request, PeerGroup $peerGroup)
    {
        $request->validate([
            'user_id' => 'required'
        ]);
        $request_user_id = $request->input('user_id');
        $user = User::where('id', $request_user_id)->first();
        if (empty($user)) {
            return response()->json([
                'message' => 'Error, User not exsits!',
            ]);
        } else {
            if ($peerGroup->users()->get()->contains($user->id)) {
                return response()->json([
                    'message' => 'Error, User has already added to this peer group',
                    'peerGroup' => $peerGroup->users()->get()
                ]);
            } else {
                $peerGroup->users()->attach($user);
                return response()->json([
                    'message' => 'Success, User is added to peer group',
                    'peerGroup' => $peerGroup->users()->get()
                ]);
            } 
        }
    }

    /**
     * @OA\Post(
     *      path="/api/peer-groups/{peerGroup_id}/detach",
     *      operationId="detach",
     *      tags={"PeerGroup"},
     *      summary="remove a user from a peerGroup by user ID",
     *      description="Returns the peer group infomation",
     *      @OA\Parameter(
     *         name="peerGroup_id",
     *         in="path",
     *         description="peer-group ID for detaching the user in path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="user ID to detach",
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
    public function detach(Request $request, PeerGroup $peerGroup)
    {
        $request->validate([
            'user_id' => 'required'
        ]);
        $request_user_id = $request->input('user_id');
        $user = User::where('id', $request_user_id)->first();
        if (empty($user)) {
            return response()->json([
                'message' => 'User not exsits!',
            ]);
        } else {
             if ($peerGroup->users()->get()->contains($user->id)) {
                $peerGroup->users()->detach($user);
                return response()->json([
                    'message' => 'Success, User is detached from peer group',
                    'peerGroup' => $peerGroup->users()->get()
                ]);
            } else {
                return response()->json([
                    'message' => 'Error, User does not exsit in peer group',
                    'peerGroup' => $peerGroup->users()->get()
                ]);
            }
        }
    }
}
