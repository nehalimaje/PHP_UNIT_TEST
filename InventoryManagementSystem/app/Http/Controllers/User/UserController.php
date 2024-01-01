<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Auth;
use Validator;


class UserController extends Controller
{
    public function loginUser(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(["status" => 401, "message" => $validator->errors()]);
        }

        if(Auth::attempt($request->all())){
            $user = Auth::user();
            $success = $user->createToken('xplor')->plainTextToken;
            return Response(['token' => $success],200);
        }else{
            return response()->json(['error' => 'Unauthorized user.']);
        }
        return Response(["message" => "email or password wrong"],401);
    }
}
