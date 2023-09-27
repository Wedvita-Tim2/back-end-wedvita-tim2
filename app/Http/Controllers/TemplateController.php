<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;


class TemplateController extends Controller
{
    public function index(){
        $data = Template::get();

        return response()->json([
            'data' => $data,
            'response' => 200
        ]);
    }

}
