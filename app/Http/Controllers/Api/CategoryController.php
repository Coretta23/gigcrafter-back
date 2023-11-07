<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        if ($Category->count() > 0) {
            return response()->json([
                'status' => 200,
                'products' => $Category,
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
                'categoryimage' => 'file|image',
            ]
        );
        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            // if ($category) {
            $data = $validator->validated();
            if (isset($request->categoryimage)) {
                $fileName = 'category_'.time().'.'.$request->categoryimage->extension();
                $request->categoryimage->move(public_path('uploads/Categories/Images'), $fileName);
                $data['categoryimage'] = $fileName;
            }
            $category = Category::create($validator->validated());
            return response()->json(
                [
                    'status' => 200,
                    'message' => "Category Created Successfully",
                ], 200);
            // } else {
            //     return response()->json(
            //         [
            //             'status' => 500,
            //             'message' => "Something Went Wrong",
            //         ], 500);
            // }
        }
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($product) {
            return response()->json(
                [
                    'status' => 200,
                    'product' => $category,
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'message' => "No Such Category Found",
                ], 404);
        }
    }
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'string|max:191',
            'categoryimage' => 'file|image',
            ]
        );
        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $category = Category::find($id);
            if ($category) {
                $data = $validator->validated();
                if (isset($request->categoryimage)) {
                    $fileName = 'category_'.time().'.'.$request->categoryimage->extension();
                    $request->categoryimage->move(public_path('uploads/Categories/Images'), $fileName);
                    $data['categoryimage'] = $fileName;
                }
                $category->update();
                return response()->json(
                    [
                        'status' => 200,
                        'message' => "Category Updated Successfully",
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
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json(
                [
                    'status' => 200,
                    'message' => "Category successfully deleted",
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'message' => "No such Category",
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

