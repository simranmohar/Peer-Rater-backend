<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Survey;
use App\Models\PeerGroup;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/peer-groups/{peer-group}/surveys/{survey}/categories",
     *      operationId="peer-groups.surveys.categories.index",
     *      tags={"Category"},
     *      summary="get the category group information by peerGroup id and survey id",
     *      description="Returns an array contains all the categories infomation",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *       ),
     *       @OA\Response(
     *          response=500, 
     *          description="Invalid input"),
     *     )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PeerGroup $peerGroup, Survey $survey)
    {
        $categories = $survey->categories()->get();

        return response()->json($categories);
    }
    /**
     * @OA\Post(
     *      path="/api/peer-groups/{peer-group}/surveys/{survey}/categories",
     *      operationId="peer-groups.surveys.categories.store",
     *      tags={"Category"},
     *      summary="get all categories infomation",
     *      description="Returns an array contains all the categories infomation",
     *      @OA\Parameter(
     *          name="description",
     *          description="Category description",
     *          required=true,
     *          example="This is a description",
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
//     {
//     "message": "Great success! New category created",
//     "category": {
//         "peer_group_id": "66",
//         "survey_id": "135",
//         "description": "Helo123123123123",
//         "updated_at": "2022-04-04T03:59:59.000000Z",
//         "created_at": "2022-04-04T03:59:59.000000Z",
//         "id": 12
//     }
// }
    public function store(Request $request, PeerGroup $peerGroup, Survey $survey)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $category = new Category;
        $category->peer_group_id = $peerGroup->id;
        $category->survey_id = $survey->id;
        $category->description = $request->input('description');
        
        $category->save();

        return response()->json([
            'message' => 'Great success! New category created',
            'category' => $category
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/peer-groups/{peer-group}/surveys/{survey}/categories/{category}",
     *      operationId="peer-groups.surveys.categories.show",
     *      tags={"Category"},
     *      summary="get a category infomation by ID",
     *      description="Returns an array contains all the categories infomation",
     *      @OA\Parameter(
     *          name="category",
     *          description="category ID",
     *          required=true,
     *          example=12,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(PeerGroup $peerGroup, Survey $survey, Category $category)
    {
        return $category;
    }

    /**
     * @OA\Put(
     *      path="/api/peer-groups/{peer-group}/surveys/{survey}/categories/{category}",
     *      operationId="peer-groups.surveys.categories.update",
     *      tags={"Category"},
     *      summary="update a category description",
     *      description="Returns the updated categories infomation",
     *      @OA\Parameter(
     *          name="category",
     *          description="category ID",
     *          required=true,
     *          example=12,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          description="category description",
     *          required=true,
     *          example="This is a description",
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PeerGroup $peerGroup, Survey $survey, Category $category)
    {
        $request->validate([
            'description' => 'nullable',
        ]);

        $category->update($request->all());
        
        if ($request->input('description')) {
            $category->description = $request->input('description');
            $category->save();
        } 

        return response()->json([
            'message' => 'Great success! Category updated',
            'category' => $category
        ]);
    }

    /**
     * @OA\Delete(
     *      path="/api/peer-groups/{peer-group}/surveys/{survey}/categories/{category}",
     *      operationId="peer-groups.surveys.categories.destroy",
     *      tags={"Category"},
     *      summary="delete a category by Category ID",
     *      description="Return the Category infomation",
     *      @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="delete category by category ID",
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
    public function destroy(PeerGroup $peerGroup, Survey $survey, Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Successfully deleted category!'
        ]);
    }
}
