<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Book;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BookResource;



class BookController extends Controller
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



        $user = DB::table('users')->join('role_user', 'role_user.userid', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.roleid')
            ->select('users.api_token')->where('users.api_token','=', $token)->get();



        //get books

        if($user->isNotEmpty()){
            $books = Book::all();
            //return collection of books as a resource
            return response()->json($books);
        }
        else {
            return response()->json(["message" => "Unavailable token"], 401);

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = $request->bearerToken();


        $user = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.userid')
            ->join('roles', 'roles.id', '=', 'role_user.roleid')
            ->select('users.api_token', 'roles.id')->where([['users.api_token','=', $token], ['roles.id', '1']])->get();
          

        //get books
        if($user->isNotEmpty() ){
            //to add new book
            $book = new Book;
            $book->bookid = $request->input('bookid');
            $book->isbn = $request->input('isbn');
            $book->author= $request->input('author');
            $book->title = $request->input('title');
            $book->status = $request->input('status');
            // $book = Book::find($bookid);
            $book->save();

            return response()->json([$book, "message" => "Book created successfully"], 200);
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
    public function show(Request $request, $bookid)
    {
        $token = $request->bearerToken();


        $user = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.userid')
            ->join('roles', 'roles.id', '=', 'role_user.roleid')
            ->select('users.api_token', 'roles.id')->where([['users.api_token','=', $token]])->get();
          
        //get a single book
        if ((Book::where('Bookid', $bookid)->exists()) && $user->isNotEmpty()) {
            $book = Book::findorfail($bookid);
            // $book = Book::where(['bookid' => $bookid])->get()->toArray();
            return response($book, 200);
          }
        //return single book as a resource
        else {
            // return response()->json([
            //   "message" => "Book not found"
            // ], 404);
            return response()->json(["message" => "Unavailable token"], 401);

          }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bookid)
    {
        $token = $request->bearerToken();


        $user = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.userid')
            ->join('roles', 'roles.id', '=', 'role_user.roleid')
            ->select('users.api_token', 'roles.id')->where([['users.api_token','=', $token], ['roles.id', '1']])->get();
          

        //update a book
        if ((Book::where('Bookid', $bookid)->exists()) && $user->isNotEmpty()) {
            $book = Book::findOrfail($request->bookid);

            $book->bookid = $bookid;
            $book->isbn = $request->input('isbn');
            $book->author= $request->input('author');
            $book->title = $request->input('title');
            $book->status = $request->input('status');

            // $book = Book::find($bookid);
            $book->save();

            return response()->json([$book, "message" => "Book was successfully updated"], 200);

        }
        else {
            // return response()->json([
            //   "message" => "Book not found"
            // ], 404);
            return response()->json(["message" => "Unavailable token"], 401);

          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $bookid)
    {
        $token = $request->bearerToken();


        $user = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.userid')
            ->join('roles', 'roles.id', '=', 'role_user.roleid')
            ->select('users.api_token', 'roles.id')->where([['users.api_token','=', $token], ['roles.id', '1']])->get();
          

        //to delete a single book
        if ((Book::where('Bookid', $bookid)->exists()) && $user->isNotEmpty() ) {
            $book = Book::find($bookid);
            $book->delete();
            return response()->json([
                "message" => "Book deleted successfully"
              ], 200);
        }
        else {
            // return response()->json([
            //   "message" => "Book not found"
            // ], 404);
            return response()->json(["message" => "Unavailable token"], 401);

          }
    }
}
