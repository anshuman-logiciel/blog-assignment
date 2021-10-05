<?php

namespace App\Http\Controllers;

use League\Fractal;
use League\Fractal\Manager;


class BaseController extends Controller
{
    public function item($user ,$transformer)
    {
        $fractal = new Manager();
        $data = new Fractal\Resource\Item($user, new $transformer); 
        $array = $fractal->createData($data)->toArray();
        return $array;
    }
    public function collection($users, $transformer)
    {
        $fractal = new Manager();
        $data = new Fractal\Resource\Collection($users, new $transformer); 
        $array = $fractal->createData($data)->toArray();
        return $array;

    }
    
}
