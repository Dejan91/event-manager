<?php

namespace App\Http\Controllers;


class FavoritesController extends Controller
{
    public function store($class, $id)
    {
        $model = "App\\" . ucfirst($class);

        $instance = $model::find($id);

        $instance->favorite();
        
        return back();
    }
}
