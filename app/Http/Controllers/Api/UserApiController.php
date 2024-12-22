<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Auth;
class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['message' => 'Success']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name'     => 'required|min:3',
                'email'    => 'required|unique:users',
                'password' => ['required','same:confirm-password',Password::min(8)]
            ];
            $message = [
                'name.required' => 'Enter the name',
            ];
            $validator = validator::make($request->all(), $rules, $message);
            if ($validator->fails()) {
                return $this->sendError('', $validator->errors());
            }
           $users =  User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
           ]);
           $data = ['email'=>$request->email,'password'=>$request->password];
           if(Auth::attempt($data)){
                $token = $users->createToken($users->email)->accessToken; 
                User::where('email',$data['email'])->update(['access_tocken'=> $token]);
                return $this->sendResponse(User::where('email',$users->email)->first()  , 'sucessfully added');
           }
        } else {
            return response()->json(['message' => 'Something error'], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
