<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    public function index(){
        return Employee::all();
    }

    public function show($id){
        $result = Employee::find($id);
        if($result){
            return $result;
        }else{
            return response()->json(['message' => "Employee not found."]);
        }
    }

    public function store(Request $request){
       
        $validator = Validator::make($request->all(),Employee::$rules);
        if($validator->fails()){
            $errorMessage = $validator->errors()->first();
            $response = [
                'status'  => false,
                'message' => $errorMessage,
            ];
            return response()->json($response, 401);
        }else{           
            Employee::create($request->all());
            return response()->json(["status" => 200, "message" => "Employee details added successfully!"]);
        }
    }

    public function update(Request $request,$id){
       $validator = Validator::make($request->all(),Employee::$rules);
       if($validator->fails()){
        $errorMessage = $validator->errors()->first();
        $response = [
            'status' => false,
            'message' => $errorMessage
        ];
        return response()->json($response,401);
       }else{
        $employee = Employee::find($id);
        if($employee){
            $employee->update($request->all());
            return response()->json(["message" => "Data updated successfully.","Updated Details" => $employee]);
        }else{
            return response()->json(['message' => "Employee Not found"]);
        }
       }
    }

    public function delete($id){
        $employee = Employee::find($id);
        if($employee){
            $employee->delete();
            return response()->json(['message' => "Employee deleted successfully."]);
        }else{
            return response()->json(['message' => "Employee not found."]);
        }
    }
    
}
