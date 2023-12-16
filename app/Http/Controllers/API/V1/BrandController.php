<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\BrandResponce;
use App\Models\API\V1\Brand;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\NullType;

class BrandController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Brand = Brand::query()->orderBy('id', 'DESC')->paginate(10);

        return $this->successResponce([
            'Data'  =>   BrandResponce::collection($Brand),
            'Links' =>   BrandResponce::collection($Brand)->response()->getData()->links,
            'Meta'  =>   BrandResponce::collection($Brand)->response()->getData()->meta,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validatedData($request->all(),[
            'name'          =>  'required|string|min:2|max:100',
            'display_name'  => 'required|string|min:2|max:100'
        ]);

        if($validator->fails())
        {
            $apiController = new ApiController();
            return $apiController->errorResponce($validator->messages() ,422);
        }


        DB::beginTransaction();

        $brand = Brand::query()->create([
            'name'          =>  $request->input('name'),
            'display_name'  =>  $request->input('display_name'),
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  null
        ]);

        DB::commit();

        return $this->successResponce((new BrandResponce($brand)), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return $this->successResponce((new BrandResponce($brand)), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validator = validatedData($request->all(),[
            'name'          =>  'required|string|min:2|max:100',
            'display_name'  => 'required|string|min:2|max:100'
        ]);

        if($validator->fails())
        {
            $apiController = new ApiController();
            return $apiController->errorResponce($validator->messages() ,422);
        }

        DB::beginTransaction();

        $brand->update([
            'name'          =>  $request->input('name'),
            'display_name'  =>  $request->input('display_name'),
            'created_at'    =>  $brand->created_at,
            'updated_at'    =>  Carbon::now()
        ]);

        DB::commit();

        return $this->successResponce( ( new BrandResponce($brand) ), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return $this->deleteResponce(200);
    }
}
