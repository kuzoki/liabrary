<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $newBook = new Book;
        $newBook->user_name = $request->user_name;
        $newBook->user_email = $request->user_email;
        $newBook->user_id = $request->user_id;
        $newBook->book_name = $request->book_name;
        $newBook->book_author = $request->book_author;
        $newBook->book_read = $request->book_read;
        $newBook->book_page_number = $request->book_page_number;
        // $newBook->unique_delete_id = $request->unique_delete_id;


        $newBook->save();
        return($newBook);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_user)
    {
        //
        $Books = Book::where('user_id', '=', $id_user)->get();
        if( $Books->isNotEmpty() ) {
            return $Books;
        }
        else{
            return 'no book';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $book = Book::find($id);
       

         if( $book ): $book->delete(); return "Book No longer in Your Library"; endif;
    }
}
