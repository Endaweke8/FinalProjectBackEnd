<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        $user=Notification::orderBy('updated_at', 'desc')->where('read_at',NULL)->get(); ;
        return response()->json($user);
    }
    public function update(Request $request, string $id)
    {
        try {
            $notification = Notification::findOrFail($id);

            // if ($request->hasFile('image')) {
            //     (new ImageService)->updateImage($user, $request, '/images/users/', 'update');
            // }

            $notification->read_at = now();
            

            $notification->save();

            return response()->json('Notification  updated', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in NotificationController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }
}
