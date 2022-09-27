<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function getProducts()
    {
        $url = config('constants.apiUrl');
        $respuesta = Http::get($url);
        $dolar = $respuesta -> json();
        return view('pages.home', compact('dolar'));
    }

    public function getCategoryProduct()
    {
        
        $url = config('constants.apiUrl' )  . 'categories?ws_key=' . config('constants.apiKey' ) . '&display=full&output_format=JSON';
        $response = Http::get($url);
        $res = $response -> json();
        $category = collect($res['categories'])->filter(function ($value) {
            return $value['id_parent'] == '2';
        });
        return view('pages.home', compact('category'));
    }
}
