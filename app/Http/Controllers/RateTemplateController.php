<?php

namespace App\Http\Controllers;
Use App\Models\RateTemplate;

use Illuminate\Http\Request;

class RateTemplateController extends Controller
{
    public function showRates(){
    $rates = RateTemplate::get(); 
    return response()->json([
        'DataRate' => $rates,
        'response' => 200
    ]);
    }
}
