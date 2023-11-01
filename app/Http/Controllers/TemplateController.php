<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

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

    public function store(Request $request){
        try{
            $validatedData = $request->validate([
                'template_name' => 'required',
                'user_id' => 'required',
                'price' => 'required',
                'thumbnail' => 'required',
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'message' => 'Validasi gagal ',
                'errors' => $e->errors()->all(), 
                'response' => 422
            ]);
        }
        if($request->hasFile('thumbnail')){
            $thumbnailName = Str::random(20) . '.webp';
            $webpImageData = Image::make($request->thumbnail);
            $webpImageData->encode('webp');
            $webpImageData->resize(200, 250);

            Storage::put('public/assets/thumbnails/' . $thumbnailName, (string) $webpImageData);
        }
        
        $validatedData['thumbnail'] = $thumbnailName;
        $template = Template::create($validatedData);
        return response()->json([
            'template' => $template,
            'message' => 'Template berhasil dibuat',
            'response' => 200,
        ]);
    }

    public function destroy($id){
        try{
            $destroy = Template::findOrFail($id);
            $destroy->delete();

            return response()->json([
                'message'   => 'Template deleted successfully',
                'status'    => 200
            ]);
        }catch(\Exception){
            return response()->json([
                'message'   => 'Not Found',
                'status'    => 404
            ]);
        }
    }

    public function update(Request $request, $id){
        $dataTemplate = Template::find($id);
        if (!$dataTemplate){
            return response()->json([
                'message' => 'Template Not Found',
                'status' => 404
            ]);
        }
        
        //save new thumbnail
        if ($request->hasFile('thumbnail')){
            //delete old thumbnail
            Storage::delete('public/assets/thumbnails/' . $dataTemplate->thumbnail);
            //update thumbnail image
            $thumbnailName = Str::random(20) . '.webp';
            $webpImageData = Image::make($request->thumbnail);
            $webpImageData->encode('webp');
            $webpImageData->resize(200, 250);
            Storage::put('public/assets/thumbnails/' . $thumbnailName, (string) $webpImageData);
            $dataTemplate->thumbnail = $thumbnailName;
        }

        //update data template
        $dataArray = [];
        if($request->template_name != NULL){
            $dataArray['template_name'] = $request->template_name;
        }
        if($request->price != NULL){
            $dataArray['price'] = $request->price;
        }
        
        $dataTemplate->update($dataArray);
        return response()->json([
            'message' => 'Template updated successfully',
            'eventInformation' => $dataTemplate,
            'status'  => 200
        ]);
    }
}
