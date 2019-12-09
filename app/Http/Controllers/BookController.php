<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Traits\APIResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{

    use APIResponser;

    public $bookService;
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

     /**
     * view a list of Books.
     *
     * @return Illuminate\Http\Response
     */
    public function index(){

        return $this->successResponse($this->bookService->index());
    }

    /**
     * create a new Books.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){

        $author = $this->authorService->show($request->author_id);
        return $this->successResponse($this->bookService->store($request->all()), Response::HTTP_CREATED);
    }

    /**
     * View an existing Books.
     *
     * @return Illuminate\Http\Response
     */
    public function show($book){

        return $this->successResponse($this->bookService->show($book));
    }

    /**
     * update an existing Books.
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book){

        return $this->successResponse($this->bookService->update($request->all(), $book));
    }

    /**
     * Remove an existing Books.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($book){

        return $this->successResponse($this->bookService->destroy($book));
    }
}
