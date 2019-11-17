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

    public function destroy($class, $id)
    {
        $model = "App\\" . ucfirst($class);

        $instance = $model::find($id);

        $instance->unfavorite();

        return back();
    }
    
}
