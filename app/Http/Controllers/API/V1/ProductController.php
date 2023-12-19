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
        return $this->successResponce([
            "Data"  =>  ProductResponce::collection($products->load('images')),
            "Links" =>  ProductResponce::collection($products)->response()->getData()->links,
            "Meta"  =>  ProductResponce::collection($products)->response()->getData()->meta
        ],200);

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
            'product_image.*'   =>      'nullabe|mimes:jpg,png,webp',
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

        if($request->product_images){
            foreach ($request->product_images as $image) {
                $imageName = generateFileNameImages($image);
                upload_image($image, env('Product_IMAGE_PATH'),$imageName);
                ProductImage::query()->create([
                    'product_id'    =>  $product->id,
                    'image'         =>  $imageName,
                    'created_at'    =>  Carbon::now(),
                    'updated_at'    =>  null
                ]);
            }
        }

        DB::commit();

        return $this->successResponce(new ProductResponce($product), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->successResponce(new ProductResponce($product->load('images')),200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = validatedData($request->all(),[
            'brand_id'          =>      'required|integer|exists:brands,id',
            'category_id'       =>      'required|integer|exists:categories,id',
            'primary_image'     =>      'nullabe|mimes:jpg,png,webp',
            'product_image.*'   =>      'nullabe|mimes:jpg,png,webp',
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

        if($request->has('primary_image')){
            $imageName = generateFileNameImages($request->primary_image);
        }

        DB::beginTransaction();

        $product = Product::query()->create([
            'brand_id'          =>  $request->input('brand_id'),
            'category_id'       =>  $request->input('category_id'),
            'primary_image'     =>  $request->has('primary_image') ? $imageName : $product->primary_image,
            'price'             =>  $request->input('price'),
            'quantity'          =>  $request->input('quantity'),
            'description'       =>  $request->input('description'),
            'delivery_amount'   =>  $request->input('delivery_amount'),
            'updated_at'        =>  Carbon::now()
        ]);
        if($request->has('primary_image')){
            upload_image($request->primary_image, env('Product_IMAGE_PATH'),$imageName);
        }
        if($request->has('product_images')){

            foreach($product->images as $image)
            {
                $image->delete();
            }

            foreach ($request->product_images as $image) {
                $imageName = generateFileNameImages($image);
                upload_image($image, env('Product_IMAGE_PATH'),$imageName);
                ProductImage::query()->create([
                    'product_id'    =>  $product->id,
                    'image'         =>  $imageName,
                    'updated_at'    =>  Carbon::now()
                ]);
            }

        }

        DB::commit();

        return $this->successResponce(new ProductResponce($product->load('images')), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        $product->delete();
        DB::commit();
        
        return $this->deleteResponce(204);
    }
}
