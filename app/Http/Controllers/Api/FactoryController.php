<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Factory;

class FactoryController extends Controller
{
    public function get_all()
    {
        
        return response()->json(Factory::all()->map(function($factory){
            return ['code'=>$factory->code,'description'=>$factory->description];
        }));
    }
    
}
