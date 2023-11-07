<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        if ($products->count() > 0) {
            return response()->json([
                'status'=> 200,
                'products' => $products,
            ], 200);
        }
            else {

                    return response()->json([
                        'status'=> 404,
                        'message' => 'No records'
                    ], 404);
            }
        }
        //Validation function
            public function store (Request $request)
            {
                $validator = Validator::make($request->all(),
                    [
                        'name' => 'required|string|max:191',
                        'about' => 'required|string|max:191',
                        'basicprice' => 'required|string|max:191',
                        'standardprice' => 'required|string|max:191',
                        'premiumprice' => 'required|string|max:191',
                    ]
            );
            if($validator-> fails()){

                return response()->json([
                    'status'=> 422,
                    'errors' => $validator->messages()
                ], 422);
                }else{
                    $product = Product::create([
                        'name' => $request ->name,
                        'about' => $request ->about,
                        'basicprice' => $request ->basicprice,
                        'standardprice' => $request ->standardprice,
                        'premiumprice' => $request ->premiumprice,
                    ]);
                    if($product){
                        return response()->json(
                            [
                                'status' => 200,
                                'message'=> "Service Created Successfully"
                            ],200);
                    }else{
                        return response()->json(
                            [
                                'status' => 500,
                                'message'=> "Something Went Wrong"
                            ],500);
                    }
                }
            }
            public function show($id)
            {
            $product = Product::find($id);
            if($product){
                return response()->json(
                    [
                        'status' => 200,
                        'product'=> $product
                    ],200);
            }else{
                return response()->json(
                    [
                        'status' => 404,
                        'message'=> "No Such Service Found"
                    ],404);
            }
            }
            public function edit($id){
                $product = Product::find($id);
                if($product){
                    return response()->json(
                        [
                            'status' => 200,
                            'product'=> $product
                        ],200);
                }else{
                    return response()->json(
                        [
                            'status' => 404,
                            'message'=> "No Such Service Found"
                        ],404);
                }
            }
            public function update(Request $request, int $id){
                $validator = Validator::make($request->all(),
                    [
                        'name' => 'required|string|max:191',
                        'about' => 'required|string|max:191',
                        'basicprice' => 'required|string|max:191',
                        'standardprice' => 'required|string|max:191',
                        'premiumprice' => 'required|string|max:191',
                    ]
            );
            if($validator-> fails()){

                return response()->json([
                    'status'=> 422,
                    'errors' => $validator->messages()
                ], 422);
                }else{
                    $product = Product::find($id);

                    if($product){

                        $product->update([
                            'name' => $request ->name,
                            'about' => $request ->about,
                            'basicprice' => $request ->basicprice,
                            'standardprice' => $request ->standardprice,
                            'premiumprice' => $request ->premiumprice,
                        ]);
                        return response()->json(
                            [
                                'status' => 200,
                                'message'=> "Service Updated Successfully"
                            ],200);
                    }else{
                        return response()->json(
                            [
                                'status' => 404,
                                'message'=> "No such Service"
                            ],404);
                    }
                }
            }
            public function destroy($id)
            {
                $product = Product::find($id);
                if($product){
                        $product->delete();
                        return response()->json(
                            [
                                'status' => 200,
                                'message'=> "Service successfully deleted"
                            ],200);
                }
                else{
                    return response()->json(
                        [
                            'status' => 404,
                            'message'=> "No such Service"
                        ],404);
                }
            }
    }


