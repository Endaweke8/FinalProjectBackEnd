<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductFeature;
use App\Http\Requests\ProducuctFeatureStoreRequest;

class ProductFeatureController extends Controller
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
    public function store(ProducuctFeatureStoreRequest $request)
    {
       try{
            $feature=ProductFeature::create([
                'title'=>$request['title'],
                'value'=>$request['value'],
                'product_id'=>$request['product_id'],
            ]);
            if($feature){
            return response()->json([
                'success'=> 'true',
                'feature'=>$feature
            ]);
          }
            // Notification::send($user,new ProductNotification($request->name));
           
        }

        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductFeatureController.store',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductFeature  $productFeature
     * @return \Illuminate\Http\Response
     */
     public function show(int $id)
    {
        try {
            $feature = ProductFeature::findOrFail($id);

            return response()->json(['product_feature' => $feature], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in PrdouctFeatureController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductFeature  $productFeature
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductFeature $productFeature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductFeature  $productFeature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
       try {
            $feature = ProductFeature::findOrFail($id);
            $feature->title=$request['title'];
            $feature->value=$request['value'];
            $feature->save();

            return response()->json('Feature Edited', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in PrdocutFeatueController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductFeature  $productFeature
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $feature = ProductFeature::where('id',$id);
            $feature->delete();

            return response()->json('feature deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductFeature.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
