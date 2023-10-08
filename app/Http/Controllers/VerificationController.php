<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class VerificationController extends Controller
{
    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'order_verification'    => 'numeric'
    ]);

    $order = Order::findOrFail($id);
    if ($order) {
        // Update the wish with the new data from the request
        $order->order_verification = 1;
        $order->save();

        return response()->json([
            'message'   => 'order_verification updated successfully',
            'status'    => 200
        ]);
    } else {
        return response()->json([
            'message'   => 'order_verification not found',
            'status'    => 404
        ]);
    }
}
}
