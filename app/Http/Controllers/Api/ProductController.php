<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        if ($products->count() > 0) {
            return response()->json([
                'status' => 200,
                'products' => $products,
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => 'No records',
            ], 404);
        }
    }
    //Validation function
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:191',
                'price' => 'required|integer',
                'description' => 'required|string',
                'shortdescription' => 'required|string',
                'coverimage' => 'required|string',
                'category' => 'required|integer',
            ]
        );
        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'shortdescription' => $request->shortdescription,
                'coverimage' => $request->coverimage,
                'category' => $request->category,

            ]);
            if ($product) {
                return response()->json(
                    [
                        'status' => 200,
                        'message' => "Service Created Successfully",
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 500,
                        'message' => "Something Went Wrong",
                    ], 500);
            }
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json(
                [
                    'status' => 200,
                    'product' => $product,
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'message' => "No Such Service Found",
                ], 404);
        }
    }
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'string|max:191',
            'about' => 'string|max:191',
            'price' => 'string|max:191',
            'description' => 'string|max:191',
            'shortdescription' => 'string|max:191',
            'coverimage' => 'string|max:191',
            'category' => 'string|max:191',
            ]
        );
        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $product = Product::find($id);

            if ($product) {

                $product->update($validator->validated());
                // $product->update([
                //     'name' => $request->name,
                //     'about' => $request->about,
                //     'basicprice' => $request->basicprice,
                //     'description' => $request->description,
                //     'shortdescription' => $request->shortdescription,
                //     'coverimage' => $request->coverimage,
                //     'category' => $request->category,

                // ]);
                return response()->json(
                    [
                        'status' => 200,
                        'message' => "Service Updated Successfully",
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 404,
                        'message' => "No such Service",
                    ], 404);
            }
        }
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(
                [
                    'status' => 200,
                    'message' => "Service successfully deleted",
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'message' => "No such Service",
                ], 404);
        }
    }




    /*public function edit($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json(
                [
                    'status' => 200,
                    'product' => $product,
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'message' => "No Such Service Found",
                ], 404);
        }
    }*/
}

