<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all_products()
    {

        

    
            try{
                $productsPerPage = 8;
                $product = Product::orderBy('updated_at', 'desc')
                    ->simplePaginate($productsPerPage);
                    $pageCount = count(Product::all()) / $productsPerPage;
                return response()->json([
                    'products' => $product,
                    'page_count' => ceil($pageCount)
                ], 200);
              }
        
            catch (\Exception $e) {
                return response()->json([
                    'message' => 'Something went wrong in AdminProductController.get_all_products',
                    'error' => $e->getMessage()
                ], 400);
            }
        
    
        

    }

    public function searchProduct(Request $request){

        
        if($request->searchData){
            $productsPerPage = 3;
            $searchProducts=Product::orderBy('updated_at', 'desc')->where('name','LIKE','%'.$request->searchData.'%')
            ->orWhere('subcategory1','LIKE','%'.$request->searchData.'%')
            ->orWhere('category','LIKE','%'.$request->searchData.'%')
            ->orWhere('price','LIKE','%'.$request->searchData.'%')
            ->orWhere('sale_price','LIKE','%'.$request->searchData.'%')
            ->orWhere('price','LIKE','%'.$request->searchData.'%')
            ->orWhere('slug','LIKE','%'.$request->searchData.'%')
            ->get();

            $searchProductsCount=Product::orderBy('updated_at', 'desc')->where('name','LIKE','%'.$request->searchData.'%')
            ->orWhere('subcategory1','LIKE','%'.$request->searchData.'%')
            ->orWhere('category','LIKE','%'.$request->searchData.'%')
            ->orWhere('price','LIKE','%'.$request->searchData.'%')
            ->orWhere('sale_price','LIKE','%'.$request->searchData.'%')
            ->orWhere('price','LIKE','%'.$request->searchData.'%')
            ->orWhere('slug','LIKE','%'.$request->searchData.'%')
            ->simplePaginate($productsPerPage);




            $pageCount = count($searchProducts) / $productsPerPage;




            return response()->json([
                'products' =>  $searchProductsCount,
                'page_count' => ceil($pageCount)
            ], 200);
        }
        else{
            return response()->json([
                'error'=>'No search found',
            ]);
        }
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
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
