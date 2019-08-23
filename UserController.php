<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
Use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // User::where('api_token', $token)->exists()

        $token = $request->bearerToken();




        $user = DB::table('users')
            ->join('role_user', 'role_user.userid', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.roleid')
            ->select('users.api_token', 'roles.id')->where([['users.api_token','=', $token], ['roles.id', '1']])->get();
          


        //get books

        if($user->isNotEmpty()){
            $users = User::all();
            //return collection of books as a resource
            return response()->json($users);
        }
        else {
            return response()->json(["message" => "Unavailable token"], 401);

        }

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $userid)
    {

        $token = $request->bearerToken();


        $user = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.userid')
            ->join('roles', 'roles.id', '=', 'role_user.roleid')
            ->select('users.api_token', 'roles.id')->where([['users.api_token','=', $token], ['roles.id', '1']])->get();
          

        //get all users
        if ((User::where('id', $userid)->exists()) && $user->isNotEmpty()) {
            $user = User::findorfail($userid);
            return response($user, 200);
          }
        //return single book as a resource
        else {
            // return response()->json([
            //   "message" => "User not found"
            // ], 404);
            return response()->json(["message" => "Unavailable token"], 401);

          }
    }

}
