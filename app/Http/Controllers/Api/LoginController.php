<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function userLogin(Request $request){
        $data = $request->all();
        $rules = [
            'email'=>'required|exists:users',
            'password' => 'required|min:8'
        ];
        $message = [
            'email.required' => 'Please enter the email',
            'email.exists' => 'Please enter the valid email',
            'password.required' => 'Please enter the password'
        ];
        $validator = Validator::make($data, $rules,$message);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
            $user = User::where('email',$data['email'])->first();
            $token = $user->createToken($user->email)->accessToken; 
            User::where('email',$user->email)->update(['access_tocken' => $token]);
            $user = User::where('email', $data['email'])->first();
            return$this->sendResponse($user,'Successfully login');
        }else{
            return $this->sendResponse($request->all(), 'Something went wrong');
        }
    }
}
