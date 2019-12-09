<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use Illuminate\Support\Facades\Log;
class AuthorService{

use ConsumesExternalService;

public $base_uri;
public $secret;

public function __construct(){

$this->base_uri = config('services.authors.base_uri');
$this->secret = config('services.authors.secret');

}

     /**
     * view a list of Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function index(){

       return $this->performRequest('GET','/authors');
    }

    /**
     * create a new Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function store($data){

        return $this->performRequest('POST','/authors', $data);
    }

    /**
     * View an existing Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function show($author){
        return $this->performRequest('GET',"/authors/{$author}");
    }

    /**
     * update an existing Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function update($data, $author){

        $data2 = implode( $data );
        Log::info("Showing data: {$data2}");

        return $this->performRequest('PUT',"/authors/{$author}", $data);
    }

    /**
     * Remove an existing Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($author){

        return $this->performRequest("DELETE","/authors/{$author}");
    }
}
