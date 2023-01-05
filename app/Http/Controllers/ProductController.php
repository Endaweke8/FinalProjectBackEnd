<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Http\Requests\Product\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
       
       
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
            'message' => 'Something went wrong in ProductController.index',
            'error' => $e->getMessage()
        ], 400);
    }



     


        // $products=Product::all();
        // return response()->json(
        //     [
        //         'products'=>$products
        //     ],200
        // );
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
            ->simplePaginate($productsPerPage);;




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


       public function AllProducts(){
          $products=Product::with('likes')->with('stars')->get();
        return response()->json(
            [
                'products'=>$products
            ],200
        );
       }
       

       public function Electronics(){
       
       
       
        $products=Product::where('category','Electronics')->get();
        return response()->json(
            [
                'products'=>$products
            ],200
        );
       }


       public function LaptopComputers(){
       
       
       
        $products=Product::where('subcategory1','Laptop')->get();
        return response()->json(
            [
                'products'=>$products
            ],200
        );
       }

       public function Clothes(){
       
       
       
        $products=Product::where('category','Clothes')->get();
        return response()->json(
            [
                'products'=>$products
            ],200
        );
       }
       
       
       
       
    //     $products=Product::all();
    //     return response()->json($products);
    //    }


       public function getImagePath(Request $request){
        $image=$request->file('image');
        $new_name=rand().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'),$new_name);
        $path=asset('images/').'/'.$new_name;

      return $path;

       }

       public function uploadpost(Request $request){
        $student=Student::create($request->all());


        $student=Student::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'image'=>$request['image'],
           
            

            
        ]);
        return response([
            'student'=>$student,
        ]);

        
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



    //  public function store(StoreProductRequest $request)
    //  {
    //      try {
    //          if ($request->hasFile('image_name') === false) {
    //              return response()->json(['error' => 'There is no image to upload.'], 400);
    //          }
 
    //          $product = new Product;
 
    //          (new ImageService)->updateImage($product, $request, '/images/products/', 'store');
 
    //          $product->name = $request->get('name');
    //          $product->slug = $request->get('slug');
    //          $product->description = $request->get('description');
    //          $product->price = $request->get('price');
    //          $product->sale_price = $request->get('sale_price');
 
    //          $product->save();
 
    //          return response()->json('New Product created', 200);
 
    //      } catch (\Exception $e) {
    //          return response()->json([
    //              'message' => 'Something went wrong in ProductController.store',
    //              'request'=>$product,
    //              'error' => $e->getMessage()
    //          ], 400);
    //      }
    //  }
    public function store(Request $request)
    {
        $product=Product::create([
            'name'=>$request['name'],
            'category'=>$request['category'],
            'subcategory'=>$request['subcategory'],
            'subcategory1'=>$request['subcategory1'],
            'slug'=>$request['slug'],
            'description'=>$request['description'],
            'image_name'=>$request['image_name'],
            'price'=>$request['price'],
            'sale_price'=>$request['sale_price']
            

            
        ]);
        return response([
            'product'=>$product,
        ]);
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
            $product = Product::findOrFail($id);

            return response()->json($product, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.show',
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
    public function update(Request $request, int $id)
    {
        try {
            $product = Product::findOrFail($id);

            // if ($request->hasFile('image')) {
            //     (new ImageService)->updateImage($user, $request, '/images/users/', 'update');
            // }

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->sale_price = $request->sale_price;
            $product->image_name = $request->image_name;

            $product->save();

            return response()->json('Product  updated', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json('Product deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
