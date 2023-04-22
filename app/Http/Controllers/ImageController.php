<?php

namespace App\Http\Controllers;

use File;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
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

    public function getImagePathMore(Request $request){
        if($request->hasFile('image')){
            // return response()->json(["rsponse"=>true]);
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;

            $file->move('images/moreproductimages',$filename);
             return $filename;
        }
        else{
            return false;
        }
      

       }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if($request->imagepath){
            $imagepath=$request->imagepath;

            // $imagepath = time() . '.' . explode('/', explode(':', substr($request->imagepath, 0, strpos($request->imagepath, ';')))[1])[1];
            // Image::make($request->imagepath)->save(public_path('images/moreproductimages/' . $imagepath));
           
        }else{
            $imagepath=null;
        }
       
        try{

            $image=ProductImage::create([
                'imagepath'=>$imagepath,
                'product_id'=>$request['product_id'],  
            ]);
            if($image){
            return response()->json([
                'success'=> 'true',
                'image'=>$image
            ]);
          }
            // Notification::send($user,new ProductNotification($request->name));
           
        }

        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ImageController.store',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {



        try {
            $image = ProductImage::findOrFail($id);

           
            if($request->imagepath){
               
                if($image->imagepath){

                    if (file_exists('images/moreproductimages/'. $image->imagepath)){
                        unlink('images/moreproductimages/'. $image->imagepath);
                    }
                 
                  else{
                    $imagepath=$request->imagepath; 
                  }
                  
                }

                $imagepath=$request->imagepath;
             
    
            }else{
                
                $imagepath=$image->imagepath;
            }

    

            $image->imagepath = $imagepath;


            $image->save();

            return response()->json('Images  updated', 200);
            

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ImageController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $image = ProductImage::findOrFail($id);
            if($image->imagepath){
                unlink(public_path('images/moreproductimages/' . $image->imagepath));
            }
        
            $image->delete();

            return response()->json(['deleted'=>true], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ImageCOntroller.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
