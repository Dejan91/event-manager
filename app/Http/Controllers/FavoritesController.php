<?php

namespace App\Http\Controllers;

/**
 * Class FavoritesController
 * @package App\Http\Controllers
 */
class FavoritesController extends Controller
{
    /**
     * @param $class
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($class, $id)
    {
        $model = "App\\" . ucfirst($class);

        $instance = $model::find($id);

        $instance->favorite();

        return response(null, 204);
    }

    /**
     * @param $class
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($class, $id)
    {
        $model = "App\\" . ucfirst($class);

        $instance = $model::find($id);

        $instance->unfavorite();

        return response(null, 204);
    }
}
