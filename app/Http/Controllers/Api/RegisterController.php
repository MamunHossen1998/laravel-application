<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function userRegister(Request $request){
        if($request->isMethod('post')){
            $data  = $request->all();
            $rules = [
                'name'     => 'required|min:3',
                'email'    => 'required|unique:users',
                'password' => 'required|min:8|same:confirm-password',//same:confirm->password
                'confirm-password' => 'required'
            ];
            $message = [
                'name.required' => 'Please enter the name',
                'name.min'      => 'Name must be minimum three character',
                'password.same' => 'Password does not match',
            ];
            $validated = Validator::make($data,$rules,$message);
            if($validated->fails()){
                return $this->sendError($validated->errors());
            }

            User::create([
                'name'    => $data['name'],
                'email'   => $data['email'],
                'password'=> Hash::make($data['password'])
            ]);
            $data = ['email'=> $data['email'], 'password'=> $data['password']];
            if(Auth::attempt($data)){
                $user  = Auth::user();
                $token = $user->createToken($user->email)->accessToken;
                $sucess_data['token']     = $token;
                $sucess_data['user_info'] = $user;
                return $this->sendResponse($sucess_data,'Sucessfully registered');

            }
            return $this->sendError('Email or password invalid','we get info');
        }
    }
}
