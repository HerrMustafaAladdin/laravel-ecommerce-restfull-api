<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\API\V1\CategoryResource;
use App\Models\API\V1\Category;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends ApiController
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->orderBy('id','DESC')->paginate(10);

        return $this->successResponce(
            [
                'Data'  =>  CategoryResource::collection($categories->load('products')),
                'Links' =>  CategoryResource::collection($categories)->response()->getData()->links,
                'Meta'  =>  CategoryResource::collection($categories)->response()->getData()->meta,
            ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = ValidatedData($request->all(),[
            'parent_id'     =>  'required|integer',
            'name'          =>  'required|string',
            'description'   =>  'required|string'
        ]);

        if($validator->fails())
        {
            return $this->errorResponce($validator->messages(), 422);
        }

        DB::beginTransaction();

        $category = Category::query()->create([
            'parent_id'     =>  $request->input('parent_id'),
            'name'          =>  $request->input('name'),
            'description'   =>  $request->input('description'),
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  null,
        ]);

        DB::commit();

        return $this->successResponce($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->successResponce(new CategoryResource($category),200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = ValidatedData($request->all(),[
            'parent_id'     =>  'required|integer',
            'name'          =>  'required|string',
            'description'   =>  'required|string'
        ]);

        if($validator->fails())
        {
            return $this->errorResponce($validator->messages(), 422);
        }

        DB::beginTransaction();

        $category->update([
            'parent_id'     =>  $request->input('parent_id'),
            'name'          =>  $request->input('name'),
            'description'   =>  $request->input('description'),
            'created_at'    =>  null,
            'updated_at'    =>  Carbon::now(),
        ]);

        DB::commit();

        return $this->successResponce($category, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        $category->delete();
        DB::commit();

        return $this->deleteResponce(200);
    }

    public function children(Category $category)
    {
        return $this->successResponce(new CategoryResource($category->load('children')),200);
    }

    public function parent(Category $category)
    {
        return $this->successResponce(new CategoryResource($category->load('parent')),200);
    }

    public function products(Category $category)
    {
        return $this->successResponce(new CategoryResource($category->load('products')),200);
    }

}
