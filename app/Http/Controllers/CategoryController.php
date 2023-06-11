<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategoryStoreRrequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Processing;

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



     


     public function CategoryByName(){
       


        $dates = Processing::pluck('created_at')->toArray();
        // Convert the dates to Carbon instances
        $carbonDates = collect($dates)->map(function ($date) {
            return Carbon::parse($date);
        });

        // Group the dates by month
        $groupedDates = $carbonDates->groupBy(function ($date) {
            return $date->format('F');
        })->sortKeys();

        $monthNames = $groupedDates->keys();

        try{




            $totalTransaction =Processing::orderBy("created_at")->select(DB::raw('SUM(FLOOR(amount)) as total_amount'), DB::raw('MONTH(created_at) as month'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

            $totalProfit =Processing::orderBy("created_at")->select(DB::raw('SUM(FLOOR(profit)) as total_profit'), DB::raw('MONTH(created_at) as month'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
         
            $sumSoldQuantity = Product::select('category_id', DB::raw('SUM(sold_quantity) as total_sold_quantity'))
            ->groupBy('category_id')
            ->get('sold_quantity')->toArray();

            $categoriesQuantity = Product::select('category_id', DB::raw('SUM(productquantity) as total_product_quantity'))
    ->groupBy('category_id')
    ->get()
    ->toArray();
    $totalQuantity = array_sum(array_column($categoriesQuantity, 'total_product_quantity'));

    $categoriesQuantityinPercent = array_map(function ($category) use ($totalQuantity) {
        $category['total_product_quantity'] = ($category['total_product_quantity'] / $totalQuantity) * 100;
        return $category;
    }, $categoriesQuantity);
          $category = Category::pluck('name')->toArray();
  
          return response()->json([
              'categories' => $category,
              "sold_quantity"=>$sumSoldQuantity,
              "one_year_months_name"=>$monthNames,
              "total_sales_on_eachmonth"=>$totalTransaction,
              "total_profit"=>$totalProfit,
              "categoriesQuantityinPercent"=>$categoriesQuantityinPercent,
              "categoriesQuantityinNumber"=>$categoriesQuantity
          ], 200);
        }
  
      catch (\Exception $e) {
          return response()->json([
              'message' => 'Something went wrong in CategoryController.index',
              'error' => $e->getMessage()
          ], 400);
        }}



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
