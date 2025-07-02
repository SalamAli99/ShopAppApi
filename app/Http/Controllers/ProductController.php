<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
 public function CreateProduct(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'category' => 'required',
        'supplier' => 'required',
        'price' => 'required',
        'avalible' => 'required|boolean',  // Ensure that the availability is a boolean (true or false)
    ]);

    // Create the product in the database
    $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'category' => $request->category,
        'supplier' => $request->supplier,
        'price' => $request->price,
        'avalible' => $request->avalible,
    ]);

    // Check if the product was created successfully
    if ($product) {
        // Return the product and success message as JSON
        return response()->json([
            'message' => 'Product created successfully!',
            'product' => $product,
            'status' => 200,
        ]);
    } else {
        // Return an error message if product creation failed
        return response()->json([
            'message' => 'Failed to create product',
            'product' => null,
            'status' => 500,
        ], 500); // Return 500 Internal Server Error status code
    }
}


public function getAllProducts()
{
    $products = Product::all();

    if ($products->isNotEmpty()) {
        return response()->json([
            'message' => 'Success',
            'data' => $products->toArray() // ✅ ensures it's a pure array
        ], 200);
    } else {
        return response()->json([
            'message' => 'No products in database',
            'data' => [] // ✅ still return an array for consistency
        ], 200);
    }
}




function getProduct($id){
   $product = Product::find($id);
   if($product){
     return response()->json([
       'message'=> 'success',
       'products' => $product,
       'status'=> 200
     ]);
   }else{
     return response()->json([
         'message'=> 'error',
         'products'=> 'Product does not exist',
         'status'=> 404
     ]);
   }
  } 


function updateProduct(Request $request,string $id){
  $request->validate([
  'name' => 'required|string',
  'description' => 'required|string',
  'category' => 'required|string',
  'supplier' => 'required|string',
  'price' => 'required|numeric',
  'avalible' => 'required|boolean'
]);
$product = Product::find($id);
if($product){
   $product->name = $request->name;
   $product->description = $request->description;
   $product->category = $request->category;
   $product->supplier = $request->supplier;
   $product->price = $request->price;
   $product->avalible = $request->avalible;

   $product->save();
   return response()->json([
     'message'=>'success',
     'products'=> $product,
     'status'=> 200
     ]);
 }
 else{
 return response()->json([
 'message'=> 'error',
 'products'=> 'Product doesn\'t exist',
 'status'=> 404
 ]);
 }
}


function deleteProduct(string $id){

   $product = Product::find($id);
   if($product){
     $product->delete();
       return response()->json([
           'message'=>'success',
           'products'=> 'Product has been deleted successfully!',
           'status'=>200
      ]);
     }
   else{
     return response()->json([
           'message'=> 'error',
           'products'=>'product does not exist!',
           'status'=>404
     ]);
     }
  }

public function filter(Request $request)
{
    // Search for a user based on their name.
 if ($request->has('category')) {
        return Product::where('category', $request->input('category'))->get();
    }

    return Product::all();
}




public function sort($direction)
{
    if (!in_array($direction, ['a', 'd'])) {
        return response()->json(['message' => 'Invalid sort direction'], 400);
    }

    $products = Product::orderBy('name', $direction === 'a' ? 'asc' : 'desc')->get();

    return response()->json([
        'message' => 'Products sorted successfully',
        'products' => $products
    ]);
}

}