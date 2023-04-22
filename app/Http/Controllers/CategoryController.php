<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryStoreRrequest;
use App\Http\Requests\CategoryUpdateRequest;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
       
       
        try{
         
          $category = Category::with('subcategories')->get();
  
          return response()->json([
              'categories' => $category,
          ], 200);
        }
  
      catch (\Exception $e) {
          return response()->json([
              'message' => 'Something went wrong in CategoryController.index',
              'error' => $e->getMessage()
          ], 400);
        }}


        public function ActiveCategory(){
       
       
            try{
             
              $category = Category::where('status','active')->get();
      
              return response()->json([
                  'categories' => $category,
              ], 200);
            }
      
          catch (\Exception $e) {
              return response()->json([
                  'message' => 'Something went wrong in CategoryController.ActiveCategory',
                  'error' => $e->getMessage()
              ], 400);
            }}

        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



     public function get_all_categories()
     {
 
     
         try{
           
             $category = Category::orderBy('updated_at', 'desc')->get();
             return response()->json([
                 'category' => $category,
             ], 200);
           }
     
         catch (\Exception $e) {
             return response()->json([
                 'message' => 'Something went wrong in CategoryController.get_all_categories',
                 'error' => $e->getMessage()
             ], 400);
         }
     
     }



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
    public function store(CategoryStoreRrequest $request)
    {
        // $user=User::first();
        try{
            $category=Category::create([
                'name'=>$request['name'],
                
            ]);
            if($category){
            return response()->json([
                'success'=> 'true',
                'category'=>$category
            ]);
          }
            // Notification::send($user,new ProductNotification($request->name));
           
        }

        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CategoryController.store',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $category = Category::findOrFail($id);

            return response()->json(['category' => $category], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CategoryController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, int $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            

            $category->save();

            return response()->json('category  updated', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CategoryController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }


    public function Active(Request $request, int $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->status = $request->status;
            

            $category->save();

            return response()->json('category  activated', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CategoryController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json('Category deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in CategoryController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
