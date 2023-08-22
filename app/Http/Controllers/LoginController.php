<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return('some information');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


//create user
/**
 * Create a debit card

*
* @return JsonResponse
*/
public function createUser(Request $request){
$validator = Validator::make($request->all(), [
'name'     => 'required',
'email'    => 'required|email|unique:users',
'password' => 'required|min:6'
]);

if ($validator->fails()){
return response()->json(['message'=>$validator->errors(),'status'=>422]);
}

$user = User::create([
'name'     => $request->name,
'email'    => $request->email,
'password' => 123456789
]);

return response()->json([
'message'=>'success',
'token'=>$user->createToken('accessToken')->accessToken]);
}



//login
public function login(Request $request){
$validator = Validator::make($request->all(), [
'email'    => 'required|email',
'password' => 'required|min:6'
]);
if ($validator->fails()){
return response()->json(['message'=>$validator->errors(),'status'=>422]);
}
$user=User::whereEmail($request->email)->first();
if(!$user){
return response()->json(['message'=>'unauthorized','status'=>422]);
}else{
$token=$user->createToken('accessToken');
return response()->json(['message'=>'success','token'=>$token]);
}
}



//dashboard
public function dashboard(){
return response()->json(['data'=>count(User::get()),'status'=>200]);
}














}
