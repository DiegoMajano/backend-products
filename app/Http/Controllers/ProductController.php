<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //get all products
    public function index()
    {
        $products = Product::all();

        if (count($products) > 0) {

            return response()->json($products, 200);
        }

        return response()->json([], 200);
    }

    // save a product
    public function store(Request $request)
    {

        // validate data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image_url' => 'required|url:http,https',
            'description' => 'required|string',
            'quantity' => 'required|integer', // must be integer
            'price' => 'required|decimal:2', // with 2 decimal
        ]);

        // validating if data its ok
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'error' => $validator->errors(),
            ], 400);
        }

        // creating instance of product
        $product = new Product();
        $product->name = $request->input('name');
        $product->image_url = $request->input('image_url');
        $product->description = $request->input('description');
        $product->quantity = $request->input('quantity');
        $product->price = $request->input('price');

        $product->save();

        return response()->json([
            'message' => 'Successfully registered',
            'product' => $product
        ], 201);
    }

    // get product by id

    public function productById($productId)
    {

        $validator = Validator::make(['id' => $productId], [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'error' => $validator->errors(),
            ], 400);
        }

        $product = Product::with('comments')->find($productId);

        if ($product) {
            return response()->json($product, 200);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }

    public function update(Request $request, $productId)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image_url' => 'required|url',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|decimal:2|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'error' => $validator->errors(),
            ], 400);
        }

        $product = Product::find($productId);

        if ($product) {

            $product->name = $request->input('name');
            $product->image_url = $request->input('image_url');
            $product->description = $request->input('description');
            $product->quantity = $request->input('quantity');
            $product->price = $request->input('price');

            $product->update();
        }


        return response()->json(['message' => 'Successfully updated'], 200);
    }

    public function destroy($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product successfully deleted'], 200);
    }
}
