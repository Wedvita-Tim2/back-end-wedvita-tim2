<?php

namespace App\Http\Controllers;
Use App\Models\RateTemplate;

use Illuminate\Http\Request;

class RateTemplateController extends Controller
{
    public function showRates(){
    $rates = RateTemplate::with(['template' => function($query){
        $query->select('id','template_name');
    }, 'user' => function($query){
        $query->select('id', 'username');
    }])->get();
    return response()->json([
        'DataRate' => $rates,
        'response' => 200
    ]);
    }
}
