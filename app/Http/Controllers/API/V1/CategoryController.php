<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\API\V1\CategoryResource;
use App\Models\API\V1\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Category = Category::query()->orderBy('id','DESC')->paginate(10);
        return $this->successResponce([
            'Data'  =>  CategoryResource::collection($Category),
            'Links' =>  CategoryResource::collection($Category)->response()->getData()->links,
            'Meta'  =>  CategoryResource::collection($Category)->response()->getData()->meta,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
