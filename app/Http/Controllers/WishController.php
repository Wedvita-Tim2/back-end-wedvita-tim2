<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\WeddingWish;

class PostController extends Controller
{

//Metode index
public function index()
{
    $posts = WeddingWish::all();
    return response()->json([
        'posts'     => $posts,
        'response'  => 200
    ]);
}

//Metode store
public function store(Request $request, $id)
{
    $validatedData = $request->validate([
        'title'     => 'required|max:255',
        'content'   => 'required',
    ]);

    $WeddingWish = WeddingWish::create([
        'guest_name'            => $request->guest_name,
        'message'               => $request->message,
        'event_information_id'  => $request->event_information_id
    ]);

    return response()->json([
        'WeddingWish'   => $WeddingWish,
        'message'       => 'created successfully',
        'response'      => 200
    ]);
}

//Metode edit
public function edit($id)
{
    $weddingWish = WeddingWish::findOrFail($id);
    return response()->json([
        'WeddingWish'   => $weddingWish,
        'message'       => 'Post found for editing',
        'status'        => 200
    ]);
}

//Metode update
public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'guest_name'    => 'required|max:255',
        'message'       => 'required',
    ]);

    $weddingWish = WeddingWish::findOrFail($id);
    if ($weddingWish) {
        // Update the wish with the new data from the request
        $weddingWish->guest_name = $request->input('guest_name');
        $weddingWish->message = $request->input('message');
        $weddingWish->event_information_id = $request->input('event_information_id');
        $weddingWish->save();

        return response()->json([
            'message'   => 'Wedding wish updated successfully',
            'status'    => 200
        ]);
    } else {
        return response()->json([
            'message'   => 'Wedding wish not found',
            'status'    => 404
        ]);
    }
}

//Metode destroy
public function destroy($id)
{
    $weddingWish = WeddingWish::findOrFail($id);
    $weddingWish->delete();

    return response()->json([
        'message'   => 'Post deleted successfully',
        'status'    => 200
    ]);
}
}