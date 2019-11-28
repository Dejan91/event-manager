<?php

namespace App\Http\Controllers;

use App\Country;

/**
 * Class CountriesController
 * @package App\Http\Controllers
 */
class CountriesController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $countries = Country::all();

        return response()->json($countries);
    }
}
