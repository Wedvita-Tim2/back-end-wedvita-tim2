<?php

namespace App\Http\Controllers;

use App\Http\Resources\TemplateResource;
use App\Models\Template;


class TemplateController extends Controller
{
    public function index(){
        $data = Template::all();
        $resource = TemplateResource::collection($data);

        return response()->json([
            'data' => $resource,
            'response' => 200
        ]);
    }

    public function show($id){
        $data = Template::findOrFail($id);
        $resource = new TemplateResource($data);

        return response()->json([
            'data' => $resource,
            'response' => 200
        ]);
    }

}
