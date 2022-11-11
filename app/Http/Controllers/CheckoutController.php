<?php

namespace App\Http\Controllers;

use App\Models\Comunas;
use App\Services\Interfaces\CartInterface;
use App\Services\Interfaces\CityInterface;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    private CartInterface $cartInterface;
    private CityInterface $cityInterface;
    private $comunas;

    public function __construct( CartInterface $cartInterface, CityInterface $cityInterface)
    {
        $this->cartInterface = $cartInterface;
        $this->cityInterface = $cityInterface;
        $this->comunas = new Comunas();
    }

    public function index(Request $request)
    {
        $cart = $this->cartInterface->getCart();
        $cities = $this->cityInterface->getAllCities();
        $viewShareVars = array_keys(get_defined_vars());
        return view('pages.checkout',  compact($viewShareVars));
    }

    public function getCitiesByIdState($idState)
    {
        $cities = $this->comunas->getAllCitiesByStateId($idState);
        return $cities;
    }
}
