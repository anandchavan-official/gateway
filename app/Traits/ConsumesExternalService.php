<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumesExternalService {

    public function performRequest($method, $requestURL, $formParams=[], $headers =[]){

        $client = new Client([
            'base_uri' => $this->base_uri,
        ]);


        if (isset($this->secret)){
            $headers['Authorization']=$this->secret;
        }

        $response = $client->request($method, $requestURL, ['form_params' => $formParams, 'headers' => $headers]);

        return $response->getBody()->getContents();
    }
}
