<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function showadminuser(int $id)
    {
        try {
            $user = User::where('id',$id)->where('role','admin')->first();;

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.showadminuser',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($request->hasFile('image')) {
                (new ImageService)->updateImage($user, $request, '/images/users/', 'update');
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->location = $request->location;
            $user->description = $request->description;

            $user->save();

            return response()->json('User details updated', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    public function passwordupdate(UpdatePasswordRequest $request, int $id)
    {
        try {
            
            $user = User::findOrFail($id);
            
            $currentPasswordStatus=Hash::check($request->oldPassword,$user->password);
            // return response()->json($currentPasswordStatus);
            if($currentPasswordStatus){
                $user->password = Hash::make($request->input('newPassword')); 
                $user->save();

            return response()->json([
                'message' => 'Password Updated',
                'success' => "true"
            ], 200); 
            }
            else{
                return response()->json([
                    'message' => 'Something went wrong in UserController.passwordupdate',
                    'errors' => "The old password did not match or incorrect"
                ], 400); 
            }


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.passwordupdate',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json('User deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
