<?php

namespace App\Services\Implement;

use App\Services\Interfaces\CityInterface;
use GuzzleHttp\Client;

class CityRepo implements CityInterface
{
    protected $url;
    protected $http;
    protected $headers;

    public function __construct(Client $client)
    {
        $this->url = config('constants.apiUrl' ) ;
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];
    }

    public function getAllCities()
    {
        $full_path = $this -> url . '/api/states?ws_key=' . config('constants.apiKey' ) . '&display=full&output_format=JSON&filter[id_country]=68'; // 68 CL
        $response = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 100,
            'connect_timeout' => true,
            'http_errors'     => true,
        ]);
        $res = json_decode($response->getBody(), true);      
        return $res;
    }
}