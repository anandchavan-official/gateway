<?php

namespace App\Http\Controllers;

use App\Traits\APIResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AuthorService;

class AuthorController extends Controller
{

    use APIResponser;

    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService =$authorService;
    }

     /**
     * view a list of Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function index(){
        return $this->successResponse($this->authorService->index());
    }

    /**
     * create a new Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        return $this->successResponse($this->authorService->store($request->all()), Response::HTTP_CREATED);
    }

    /**
     * View an existing Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function show($author){
        return $this->successResponse($this->authorService->show($author));
    }

    /**
     * update an existing Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author){

        return $this->successResponse($this->authorService->update($request->all(), $author));
    }

    /**
     * Remove an existing Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($author){

        return $this->successResponse($this->authorService->destroy($author));
    }
}
