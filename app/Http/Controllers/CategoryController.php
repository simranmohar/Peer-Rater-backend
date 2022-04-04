<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Survey;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/categories",
     *      operationId="categories.index",
     *      tags={"Category"},
     *      summary="get all categories infomation",
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
     */   
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories);
    }
    /**
     * @OA\Post(
     *      path="/api/categories",
     *      operationId="categories.store",
     *      tags={"Category"},
     *      summary="get all categories infomation",
     *      description="Returns an array contains all the categories infomation",
     *      @OA\Parameter(
     *          name="description",
     *          description="Category description",
     *          required=true,
     *          example="This is a description",
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="peer_group_id",
     *          description="Category description",
     *          required=true,
     *          example=12,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="survey_id",
     *          description="Survey description",
     *          required=true,
     *          example=135,
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
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $category = new Category;
        $survey = Survey::with('categories')->where('id', $request->input('survey_id'))->get();
        $category->peer_group_id = $request->input('peer_group_id');
        $category->survey_id = $request->input('survey_id');
        $category->description = $request->input('description');
        $category->save();

        return response()->json([
            'message' => 'Great success! New category created',
            'category' => $category
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/categories/{category}",
     *      operationId="categories.show",
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
     */   
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * @OA\Put(
     *      path="/api/categories/{category}",
     *      operationId="categories.update",
     *      tags={"Category"},
     *      summary="update a category description",
     *      description="Returns the updated categories infomation",
     *      @OA\Parameter(
     *          name="description",
     *          description="category description",
     *          required=true,
     *          example="This is a description",
     *          in="path",
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
    public function update(Request $request, Category $category)
    {
        $request->validate([
           'description' => 'nullable'
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
     *      path="/api/categories/{category}",
     *      operationId="categories.destroy",
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
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Successfully deleted category!'
        ]);
    }
}
