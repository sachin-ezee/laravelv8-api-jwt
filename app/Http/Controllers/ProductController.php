<?php
namespace App\Http\Controllers;
/**
 * 
 * @group Products
 */
use App\Models\Product;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display All Products.
     *
     * @authenticated	
     * @header Authorization Bearer {YOUR_AUTH_KEY}
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $get_products = $this->user->products()->get();
        return response()->json([
            'error' => false,
            'message' => 'All Product found.',
            'result' => $get_products 
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @authenticated	
     * @header Authorization Bearer {YOUR_AUTH_KEY}
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created Product.
     *
     * @authenticated	
     * @header Authorization Bearer {YOUR_AUTH_KEY}
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'sku', 'price', 'quantity');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'sku' => 'required|unique:products',
            'price' => 'required',
            'quantity' => 'required'
        ],[],['name'=>'Product Name']);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => true,'message' => $validator->messages()], 200);
        }

        //Request is valid, create new product
        $product = $this->user->products()->create([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        //Product created, return success response
        return response()->json([
            'error' => false,
            'message' => 'Product created successfully',
            'data' => $product
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified Product.
     *
     * @authenticated	
     * @header Authorization Bearer {YOUR_AUTH_KEY}
     * 
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->user->products()->find($id);
    
        if (!$product) {
            return response()->json([
                'error' => true,
                'message' => 'Sorry, product not found.'
            ], 400);
        }
        return response()->json([
            'error' => false,
            'message' => 'Product found.',
            'result' => $product
        ]);
    }

    /**
     * Show the form for editing the specified product.
      * @authenticated	
     * @header Authorization Bearer {YOUR_AUTH_KEY}
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in product.
      * @authenticated	
     * @header Authorization Bearer {YOUR_AUTH_KEY}
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //Validate data
        $data = $request->only('name', 'sku', 'price', 'quantity');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'sku' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => true,'message' => $validator->messages()], 200);
        }

        //Request is valid, update product
        $product = $product->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        //Product updated, return success response
        return response()->json([
            'error' => false,
            'message' => 'Product updated successfully',
            'result' => $product
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified product from storage.
     * @authenticated	
     * @header Authorization Bearer {YOUR_AUTH_KEY}
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return response()->json([
            'error' => false,
            'message' => 'Product deleted successfully'
        ], Response::HTTP_OK);
    }
}