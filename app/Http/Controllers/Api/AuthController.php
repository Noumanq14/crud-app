<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails())
            return response()->json(['status' => 0, 'message' => $validator->errors()],400);

        $aArrayReturn = array();
        if (Auth::attempt(['email' => $request["email"], 'password' => $request["password"]]))
        {
            $user = Auth::user();
            $data = [
                'token' => $user->createToken('MyApp')->plainTextToken,
                'userName' => $user->name
            ];

            $aArrayReturn = [
                'status' => 1,
                'data' => $data,
                'message' => 'Login Successfully'
            ];

            return response()->json($aArrayReturn);
        }
        else
            return response()->json(['status' => 0, 'message' => 'Unauthorised User'],400);
    }
}
