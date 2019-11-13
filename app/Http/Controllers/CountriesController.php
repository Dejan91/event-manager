<?php

namespace App\Http\Controllers;

use App\Country;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        return response()->json($countries);
    }
}
