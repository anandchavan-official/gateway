<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use Illuminate\Support\Facades\Log;

class BookService{

use ConsumesExternalService;

public $base_uri;
public $secret;

public function __construct(){

$this->base_uri = config('services.books.base_uri');
$this->secret = config('services.books.secret');

}

/**
     * view a list of Books.
     *
     * @return Illuminate\Http\Response
     */
    public function index(){

        return $this->performRequest('GET','/books');
    }

    /**
     * create a new Books.
     *
     * @return Illuminate\Http\Response
     */
    public function store($data){

        return $this->performRequest('POST','/books', $data);
    }

    /**
     * View an existing Books.
     *
     * @return Illuminate\Http\Response
     */
    public function show($book){

        return $this->performRequest('GET',"/books/{$book}");
    }

    /**
     * update an existing Books.
     *
     * @return Illuminate\Http\Response
     */
    public function update($data, $book){

        $data2 = implode( $data );
        Log::info("Showing data: {$data2}");

        return $this->performRequest('PUT',"/books/{$book}", $data);
    }

    /**
     * Remove an existing Books.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($book){

        return $this->performRequest("DELETE","/books/{$book}");
    }

}
