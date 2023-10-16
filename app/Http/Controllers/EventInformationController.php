<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventInformation;
use Illuminate\Support\Facades\Validator;

class EventInformationController extends Controller
{
    //Metode update
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bride_name'            => 'required |max:255',
            'groom_name'            => 'required |max:255',
            'bride_mother_name'     => 'required |max:255',
            'bride_father_name'     => 'required |max:255',
            'groom_mother_name'     => 'required |max:255',
            'groom_father_name'     => 'required |max:255',
            'cover_image'           => 'required',
            'date_event'            => 'required',
            'guests'                => 'required',
            'account_number'        => 'numeric',
            'account_holder_name'   => 'required',
            'quotes'                => 'required',
            'address'               => 'required',
            'building_name'         => 'required',
            'lat'                   => 'numeric',
            'lng'                   => 'numeric'
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal ' + $validator->errors(), 
                'errors' => $validator->errors(), 
                'response' => 422
            ]);
        }

        $eventinformation = EventInformation::findOrFail($id);
        if ($eventinformation) {
            $eventinformation->bride_name = $request->input('bride_name');
            $eventinformation->groom_name = $request->input('groom_name');
            $eventinformation->bride_mother_name = $request->input('bride_mother_name');
            $eventinformation->bride_father_name = $request->input('bride_father_name');
            $eventinformation->groom_mother_name = $request->input('groom_mother_name');
            $eventinformation->groom_father_name = $request->input('groom_father_name');
            $eventinformation->cover_image = $request->input('cover_image');
            $eventinformation->date_event = $request->input('date_event');
            $eventinformation->guests = $request->input('guests');
            $eventinformation->account_number = $request->input('account_number');
            $eventinformation->account_holder_name = $request->input('account_holder_name');
            $eventinformation->quotes = $request->input('quotes');
            $eventinformation->address = $request->input('address');
            $eventinformation->building_name = $request->input('building_name');
            $eventinformation->lat = $request->input('lat');
            $eventinformation->lng = $request->input('lng');
            $eventinformation->save();

            return response()->json([
                'message' => 'Event Information updated successfully',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Event Information not found',
                'status' => 404
            ]);
        }
    }

    public function destroy($id)
    {
        $destroy = EventInformation::findOrFail($id);
        $destroy->delete();

        return response()->json([
            'message'   => 'Post deleted successfully',
            'status'    => 200
        ]);
    }

}
