<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Regster(Request $request)
    {

        $code = rand(100000, 999999);
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'code' => $code ,
            'verfication' => 'No',
            'password' => Hash::make($request['password']),
        ]);

        return $code;

        //
    }

    /**
     * verfication the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function Verfication(Request $request)
    {
        //

        if(!empty($request->code)){
            $user = User::where('code' , (int)$request->code)->first();
            if($user){
                if($user->verfication == "No"){
                    $user->verfication = "Yes";
                    $user->save();
                    return "activated";
                }else{
                    return "Already activated";
                }
            }else{
             return "The code is incorrect";
            }
        }else{
            return "code Is Requerd";
        }
    }


}
