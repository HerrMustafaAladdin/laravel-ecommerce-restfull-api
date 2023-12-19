<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\ProductResponce;
use App\Models\API\V1\Product;
use App\Models\API\V1\ProductImage;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->orderBy('id','DESC')->paginate(10);
        return $this->successResponce(ProductResponce::collection($products),200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validatedData($request->all(),[
            'brand_id'          =>      'required|integer|exists:brands,id',
            'category_id'       =>      'required|integer|exists:categories,id',
            'primary_image'     =>      'required|mimes:jpg,png,webp',
            'product_image.*'   =>      'required|mimes:jpg,png,webp',
            'price'             =>      'required|string',
            'quantity'          =>      'required|string',
            'description'       =>      'required|string',
            'delivery_amount'   =>      'required|string',
        ]);

        if($validator->fails())
        {
            $apiController = new ApiController();
            return $apiController->errorResponce($validator->messages() ,422);
        }

        $imageName = generateFileNameImages($request->primary_image);

        DB::beginTransaction();

        $product = Product::query()->create([
            'brand_id'          =>  $request->input('brand_id'),
            'category_id'       =>  $request->input('category_id'),
            'primary_image'     =>  $imageName,
            'price'             =>  $request->input('price'),
            'quantity'          =>  $request->input('quantity'),
            'description'       =>  $request->input('description'),
            'delivery_amount'   =>  $request->input('delivery_amount'),
            'created_at'        =>  Carbon::now(),
            'updated_at'        =>  null
        ]);
        
        upload_image($request->primary_image, env('Product_IMAGE_PATH'),$imageName);

        foreach ($request->product_image as $image) {
            $imageName = generateFileNameImages($image);
            upload_image($image, env('Product_IMAGE_PATH'),$imageName);
            ProductImage::query()->create([
                'product_id'    =>  1,
                'image'         =>  $imageName,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  null
            ]);
        }

        DB::commit();



        return $this->successResponce((new ProductResponce($product)), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
