<?php

namespace App\Http\Controllers\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use Validator;
//use Request;


class CategoryController extends Controller
{

    public function index(){
        return CategoryModel::with('items')->where('isActive','=',0)->get();
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'category_name' => 'required',
            'category_desc' => 'required'
        ]);

         $data = array(
            'category_name' => $request->category_name,  
            'category_desc' => $request->category_desc  
         );

        if($validator->fails()){
            $errorMessage = $validator->errors()->first();
            $response = [
                'status'  => false,
                'message' => $errorMessage,
            ];
            return response()->json($response, 401);
        }else{
            $result = CategoryModel::create($data);
            return response()->json(["status" => 400,"message" => "Category Addes successfully!"]);
        }
    }

    public function update(Request $request, $id){
        
        $category = CategoryModel::find($id);
        $category->category_name = $request->input('category_name');
        $category->category_desc = $request->input('category_desc');
        if($category->save()){
            return response()->json(["message" => "Category Updated!"],404);
        }else{
            return response()->json(["message" => "Category not Updated"]);
        }
        
    }

    public function getCategory(Request $request,$id){
        $category = CategoryModel::with('items')->where('id','=',$id)->get();
        if($category){
            return response()->json(["categoryDetails" => $category]);
        }else{
            return response()->json(["message" => "No data found."]);
        }
    }

    public function delete(Request $request, $id){
        $category = CategoryModel::find($id);
        if($category){
            $category->isActive = 1;
            $category->save();
            return response()->json(["message" => "Category deleted successfully!"],202); 
        }else{
            return response()->json(["message" => "Category ID not found.!"]);
        }
        
    }
}
