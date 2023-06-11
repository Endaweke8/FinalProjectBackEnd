<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Intervention\Image\Facades\Image;
use App\Notifications\ProductNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Product\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

     public function ShowAllProductsForSlide(){
       
       
        try{
          
          $product = Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->get();
           
          return response()->json([
              'products' => $product,
             
          ], 200);
        }
  
      catch (\Exception $e) {
          return response()->json([
              'message' => 'Something went wrong in ProductController.ShowAllProductsForSlide',
              'error' => $e->getMessage()
          ], 400);
      }
  
         }
  



    public function index(){
       
       
      try{
        $date = Carbon::today()->subDays(1);
        $productsPerPage = 20;
        $product = Product::where('updated_at', '<', $date)->where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')
            ->simplePaginate($productsPerPage);
            $pageCount = count(Product::where('updated_at', '<', $date)->where('productquantity','>',0)->get()) / $productsPerPage;

        return response()->json([
            'products' => $product,
            'page_count' => ceil($pageCount),
           
        ], 200);
      }

    catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong in ProductController.index',
            'error' => $e->getMessage()
        ], 400);
    }

    



     

       }


       public function getRelatedProducts(int $id)
     {


        try{
            $product = Product::findOrFail($id);
            $categoryId=$product->category_id;
            $subcategory1=$product->subcategory1;

            // return response()->json([
            //     'related product category id' => $categoryId,
               
            // ], 200);

            $relatedProducts = Product::where('productquantity','>',0)->where('subcategory1',$subcategory1)->where('id','!=',$product->id)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->get();
             
            return response()->json([
                 'relatedproducts' => $relatedProducts,
               
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.getRelatedController',
                'error' => $e->getMessage()
            ], 400);
        }
    
           
     }





    public function getCategory(int $id){
       
       
        try{
        //   $date = Carbon::today()->subDays(1);
          $productsPerPage = 20;
          $product = Product::where('category_id', '=', $id)->where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')
              ->simplePaginate($productsPerPage);
              $pageCount = count(Product::where('category_id', '=', $id)->where('productquantity','>',0)->get()) / $productsPerPage;
  
          return response()->json([
              'products' => $product,
              'page_count' => ceil($pageCount)
          ], 200);
        }
  
      catch (\Exception $e) {
          return response()->json([
              'message' => 'Something went wrong in ProductController.getCategory',
              'error' => $e->getMessage()
          ], 400);
      }
  
      
  
  
  
       
  
         }




    public function latestproducts(){
       
       
        try{
            $date = Carbon::today()->subDays(1);
        // $blood = addBloodModel::where('created_at', '<=', $date)->get();
          $productsPerPage = 20;
          $product = Product::where('created_at', '>=', $date)->where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')
              ->simplePaginate($productsPerPage);
              $pageCount = count(Product::where('updated_at', '>=', $date)->where('productquantity','>',0)->get()) / $productsPerPage;

          return response()->json([
              'products' => $product,
              'page_count' => ceil($pageCount),
            
          ], 200);
        }
  
      catch (\Exception $e) {
          return response()->json([
              'message' => 'Something went wrong in ProductController.index',
              'error' => $e->getMessage()
          ], 400);
      }
  
  
     
       
  
         }


         public function topsoldproducts(){
       
       
            try{
                // $date = Carbon::today()->subDays(1);
            // $blood = addBloodModel::where('created_at', '<=', $date)->get();
            // $topSoldProducts = Product::orderBy('sold_quantity','DESC')->limit(10)->get();

            
              $product =Product::orderBy('sold_quantity','DESC')->where('productquantity','>',0)->where("sold_quantity", ">",0)->with('likes')->with('stars')->limit(10)
                  ->get();
                  
    
              return response()->json([
                  'products' => $product,
                 
                 
              ], 200);
            }
      
          catch (\Exception $e) {
              return response()->json([
                  'message' => 'Something went wrong in ProductController.index',
                  'error' => $e->getMessage()
              ], 400);
          }
        }
  


       public function searchProduct(Request $request){

        
        if($request->searchData){
            $productsPerPage = 8;
            $searchProducts=Product::where('productquantity','>',0)->orderBy('updated_at', 'desc')->where('name','LIKE','%'.$request->searchData.'%')
            ->orWhere('subcategory1','LIKE','%'.$request->searchData.'%')
            ->orWhere('category','LIKE','%'.$request->searchData.'%')
            ->orWhere('price','LIKE','%'.$request->searchData.'%')
            ->orWhere('sale_price','LIKE','%'.$request->searchData.'%')
            ->orWhere('price','LIKE','%'.$request->searchData.'%')
            ->orWhere('slug','LIKE','%'.$request->searchData.'%')
            ->get();

            $searchProductsCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('name','LIKE','%'.$request->searchData.'%')
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


       public function get_total_products()
    {

    
        try{
         
             $productCount = count(Product::all());
    
            return response()->json([
                'totalProducts' => $productCount,
                
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.get_total_producs',
                'error' => $e->getMessage()
            ], 400);
        }
    }



    public function get_total_soldproducts()
    {

    
        try{
         
             $productSoldCount = count(Product::where('productquantity','<',1)->get());
    
            return response()->json([
                'totalSoldProducts' => $productSoldCount,
                
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.get_total_soldproducts',
                'error' => $e->getMessage()
            ], 400);
        }
    }




       public function AllProducts(){
          $products=Product::with('likes')->with('stars')->with('images')->with('comments')->with('product_feature')->get();
        return response()->json(
            [
                'products'=>$products
            ],200
        );
       }
       

       public function Electronics(){
       
       
       
        $products=Product::where('productquantity','>',0)->where('category','Electronics')->get();
        return response()->json(
            [
                'products'=>$products
            ],200
        );
       }


    //    public function LaptopComputers(){
       
       
       
    //     $products=Product::where('subcategory1','Laptop')->get();
    //     return response()->json(
    //         [
    //             'products'=>$products
    //         ],200
    //     );
    //    }




       public function LaptopComputers(){
       
        try{
            $productsPerPage = 12;
            $laptopComputer = Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','Laptop')->get();       
            $laptopComputersCount=where('productquantity','>',0)->Product::orderBy('updated_at', 'desc')->where('subcategory1','Laptop') ->simplePaginate($productsPerPage);
          
            $pageCount = count($laptopComputer) / $productsPerPage;

            return response()->json([
                'products' => $laptopComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.LaptopComputers',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }


       public function HpLaptopComputers(){
       
        try{
            $productsPerPage = 12;
            $laptopComputer = Product::where('productquantity','>',0)->orderBy('updated_at', 'desc')->where('subcategory1','HpLaptop')->get();       
            $laptopComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','HpLaptop') ->simplePaginate($productsPerPage);
          
            $pageCount = count($laptopComputer) / $productsPerPage;

            return response()->json([
                'products' => $laptopComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.HpLaptopComputers',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }



       public function AppleLaptopComputers(){
       
        try{
            $productsPerPage = 12;
            $laptopComputer = Product::where('productquantity','>',0)->orderBy('updated_at', 'desc')->where('subcategory1','AppleLaptop')->get();       
            $laptopComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','AppleLaptop') ->simplePaginate($productsPerPage);
          
            $pageCount = count($laptopComputer) / $productsPerPage;

            return response()->json([
                'products' => $laptopComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.AppleLaptop',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }

       public function LenevoLaptopComputers(){
       
        try{
            $productsPerPage = 12;
            $laptopComputer = Product::where('productquantity','>',0)->orderBy('updated_at', 'desc')->where('subcategory1','LenevoLaptop')->get();       
            $laptopComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','LenevoLaptop') ->simplePaginate($productsPerPage);
          
            $pageCount = count($laptopComputer) / $productsPerPage;

            return response()->json([
                'products' => $laptopComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.LenevoLaptop',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }


       public function HpDesktopComputers(){
       
        try{
            $productsPerPage = 12;
            $desktopComputer = Product::where('productquantity','>',0)->orderBy('updated_at', 'desc')->where('subcategory1','HpDesktop')->get();       
            $desktopComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','HpDesktop') ->simplePaginate($productsPerPage);
          
            $pageCount = count($desktopComputer) / $productsPerPage;

            return response()->json([
                'products' => $desktopComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.HpDesktopComputers',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }
     
      
       public function AppleDesktopComputers(){
       
        try{
            $productsPerPage = 12;
            $desktopComputer = Product::where('productquantity','>',0)->orderBy('updated_at', 'desc')->where('subcategory1','AppleDesktop')->get();       
            $desktopComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','AppleDesktop') ->simplePaginate($productsPerPage);
          
            $pageCount = count($desktopComputer) / $productsPerPage;

            return response()->json([
                'products' => $desktopComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.AppleDesktopComputers',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }


    


       public function LenevoDesktopComputers(){
       
        try{
            $productsPerPage = 12;
            $desktopComputer = Product::orderBy('updated_at', 'desc')->where('subcategory1','LenevoDesktop')->get();       
            $desktopComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','LenevoDesktop') ->simplePaginate($productsPerPage);
          
            $pageCount = count($desktopComputer) / $productsPerPage;

            return response()->json([
                'products' => $desktopComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.LenevoDesktop',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }

     


     
       public function DesktopComputers(){
       
        try{
            $productsPerPage = 12;
            $desktopComputer = Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','Desktop')->get();       
            $desktopComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','Desktop') ->simplePaginate($productsPerPage);
          
            $pageCount = count($desktopComputer) / $productsPerPage;

            return response()->json([
                'products' => $desktopComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.DesktopComputers',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }



       public function IphoneMobiles(){
       
        try{
            $productsPerPage = 12;
            $mobileComputer = Product::where('productquantity','>',0)->orderBy('updated_at', 'desc')->where('subcategory1','Iphone')->get();       
            $mobileComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->where('subcategory1','Iphone') ->simplePaginate($productsPerPage);
          
            $pageCount = count($mobileComputer) / $productsPerPage;

            return response()->json([
                'products' => $mobileComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.Mobiles',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }
       public function AndroidMobiles(){
       
        try{
            $productsPerPage = 12;
            $mobileComputer = Product::where('productquantity','>',0)->orderBy('updated_at', 'desc')->where('subcategory1','Android')->get();       
            $mobileComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->where('subcategory1','Android') ->simplePaginate($productsPerPage);
          
            $pageCount = count($mobileComputer) / $productsPerPage;

            return response()->json([
                'products' => $mobileComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.AndroidMobiles',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }

       public function ButtonMobiles(){
       
        try{
            $productsPerPage = 8;
            $mobileComputer = Product::where('productquantity','>',0)->orderBy('updated_at', 'desc')->where('subcategory1','Button')->get();       
            $mobileComputersCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->where('subcategory1','Button') ->simplePaginate($productsPerPage);
          
            $pageCount = count($mobileComputer) / $productsPerPage;

            return response()->json([
                'products' => $mobileComputersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.ButtonMobiles',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }

       public function MensTrousers(){
       
        try{
            $productsPerPage = 4;
            $menTrouser = Product::orderBy('updated_at', 'desc')->where('subcategory1','MenTrouser')->get();       
            $menTrousersCount=Product::orderBy('updated_at', 'desc')->where('subcategory1','MenTrouser') ->simplePaginate($productsPerPage);
          
            $pageCount = count($menTrouser) / $productsPerPage;

            return response()->json([
                'products' => $menTrousersCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.MenTrousers',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }


       
       public function Televisions(){
       
        try{
            $productsPerPage = 12;
            $televisions = Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','FlatTv')->get();       
            $televisionsCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','FlatTv')->simplePaginate($productsPerPage);
          
            $pageCount = count($televisions) / $productsPerPage;

            return response()->json([
                'products' => $televisionsCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.Televisions',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }


       public function HeadSets(){
       
        try{
            $productsPerPage = 12;
            $headsets = Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','HeadSet')->get();       
            $headsetsCount=Product::where('productquantity','>',0)->with('likes')->with('stars')->orderBy('updated_at', 'desc')->where('subcategory1','HeadSet')->simplePaginate($productsPerPage);
          
            $pageCount = count($headsets) / $productsPerPage;

            return response()->json([
                'products' => $headsetsCount,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.HeadSets',
                'error' => $e->getMessage()
            ], 400);
        }
                
       }
       
       
    //     $products=Product::all();
    //     return response()->json($products);
    //    }


       public function getImagePath(Request $request){
        if($request->hasFile('image')){
            // return response()->json(["rsponse"=>true]);
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;

            $file->move('images/productprofiles',$filename);
             return $filename;
        }
        else{
            return false;
        }
      

       }


       public function getVideoPath(Request $request){
        if($request->hasFile('video')){
            // return response()->json(["rsponse"=>true]);
            $file=$request->file('video');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;

            $file->move('videos/productvideos',$filename);
             return $filename;
        }
        else{
            return false;
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
    public function store(StoreProductRequest $request)
    {
        // $user=User::first();
        try{
            $product=Product::create([
                'name'=>$request['name'],
                'category'=>$request['category'],
                'subcategory'=>$request['subcategory'],
                'subcategory1'=>$request['subcategory1'],
                'slug'=>$request['slug'],
                'description'=>$request['description'],
                'image_name'=>$request['image_name'],
                'buying_price'=>$request['buying_price'],
                'price'=>$request['price'],
                'sale_price'=>$request['sale_price'],
                'productquantity'=>$request['productquantity'], 
                'category_id'=>$request['category_id'],
                'videopath'=>$request['videopath'] 

            ]);
            if($product){
            return response()->json([
                'success'=> 'true',
                'product'=>$product
            ]);
          }
            // Notification::send($user,new ProductNotification($request->name));
           
        }

        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.store',
                'errors' => $e->getMessage()
            ], 400);
        }
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
            $product = Product::where('id',$id)->with('images')->with('product_feature')->first();

            return response()->json(["editproduct"=>$product], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.show',
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function showSingleProduct(int $id)
    {
        try {
            $product = Product::where('id', $id)->get(['productquantity']);

            return response()->json($product, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.showSingleProduct',
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
           
            if($request->image_name){
               
                if($product->image_name){

                    if (file_exists('images/productprofiles/'. $product->image_name)){
                        unlink('images/productprofiles/'. $product->image_name);
                    }
                 
                  else{
                    $image_name=$request->image_name; 
                  }
                  
                }

                $image_name=$request->image_name;
                // $image_name = time() . '.' . explode('/', explode(':', substr($request->image_name, 0, strpos($request->image_name, ';')))[1])[1];

                // $jpg = (string) Image::make($image_name)->encode('jpg', 75);
                
                // Image::make($request->image_name->getRealPath())->save(public_path('images/productprofiles/' . $image_name));
               
    
            }else{
                
                $image_name=$product->image_name;
            }


            if($request->videopath){

               
                if($product->videopath){

                    if (file_exists('videos/productvideos/'. $product->vidoepath)){
                        unlink('videos/productvideos/'. $product->videopath);
                    }
                 
                  else{
                    $videopath=$request->videopath; 
                  }
                  
                }

                $videopath=$request->videopath;
                // $image_name = time() . '.' . explode('/', explode(':', substr($request->image_name, 0, strpos($request->image_name, ';')))[1])[1];

                // $jpg = (string) Image::make($image_name)->encode('jpg', 75);
                
                // Image::make($request->image_name->getRealPath())->save(public_path('images/productprofiles/' . $image_name));
               
    
            }else{
                
                $videopath=$product->videopath;
            }

            // if ($request->hasFile('image')) {
            //     (new ImageService)->updateImage($user, $request, '/images/users/', 'update');
            // }

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->category = $request->category;
            $product->category_id = $request->category_id;
            $product->subcategory = $request->subcategory;
            $product->subcategory1 = $request->subcategory1;
            $product->productquantity = $request->productquantity;
            $product->description = $request->description;
            $product->buying_price = $request->buying_price;
            $product->price = $request->price;
            $product->sale_price = $request->sale_price;
            $product->image_name =$image_name;
            $product->videopath =$videopath;
            $product->save();

            return response()->json('Product  updated', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.update',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    public function DecreaseProduct(Request $request, int $id)
    {
        try {
            $product = Product::findOrFail($id);

            // if ($request->hasFile('image')) {
            //     (new ImageService)->updateImage($user, $request, '/images/users/', 'update');
            // }

            
            $product->productquantity = $product->productquantity-$request->productquantity;
            $product->sold_quantity = $product->sold_quantity+$request->productquantity;
           
            $product->save();

            return response()->json('Product  updated', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.DecreaseProduct',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    public function CheckoutForPayment(Request $request, int $id)
    {
        try {
           
            $product = Product::findOrFail($id);
            $cart=Cart::where('product_id',$id)->first();
           
            // if ($request->hasFile('image')) {
            //     (new ImageService)->updateImage($user, $request, '/images/users/', 'update');
            // }
             $result= $product->productquantity-$cart->quantity;
             if($result<0){
               $cart->quantity=$product->productquantity;
             }
            
            // $product->productquantity = $product->productquantity-$request->productquantity;
            // $product->sold_quantity = $product->sold_quantity+$request->productquantity;
           
            $cart->save();

            return response()->json([
                "carttt"=>$cart,
                // "result"=>$result,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in ProductController.CheckoutForPayment',
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
