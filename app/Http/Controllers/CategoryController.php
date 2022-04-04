<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Survey;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey)
    {
        $categories = $survey->categories()->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        $category = $survey->categories()->create($request->all());

        return response()->json([
            'message' => 'Great success! New category created',
            'category' => $category
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey, Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey, Category $category)
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $categorys
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey, Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Successfully deleted category!'
        ]);
    }
}
