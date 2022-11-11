<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunas
{
    public function getAllCitiesByStateId($idState){
        $cities = json_decode(file_get_contents(__DIR__ . '/../../public/js/comunas.js'), true);
        $filterCities = [];
      
        foreach ($cities['regiones'] as $key => $value){
            if($value['region'] == (int)$idState)
                array_push($filterCities, $value);
        }

        return $filterCities[0]['comunas'];
    }
}