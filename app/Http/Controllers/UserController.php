<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all_users()
    {

    
        try{
            $usersPerPage = 8;
            $user = User::orderBy('updated_at', 'desc')
                ->simplePaginate($usersPerPage);
                $pageCount = count(User::all()) / $usersPerPage;
    
            return response()->json([
                'users' => $user,
                'page_count' => ceil($pageCount)
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.get_all_users',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    
         
    
           
    $user=User::orderBy('id','DESC')->get();
    return response()->json([
    'users'=>$user
    ],200);
    }



    public function get_total_users()
    {

    
        try{
         
             $userCount = count(User::all());
    
            return response()->json([
                'totalUsers' => $userCount,
                
            ], 200);
          }
    
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in UserController.get_total_users',
                'error' => $e->getMessage()
            ], 400);
        }
    
    
    
         
    
           
    $user=User::orderBy('id','DESC')->get();
    return response()->json([
    'users'=>$user
    ],200);
    }


    public function searchUser(Request $request){

        
        if($request->searchData){
            $usersPerPage = 8;
            $searchUsers=User::orderBy('updated_at', 'desc')->where('first_name','LIKE','%'.$request->searchData.'%')
            ->orWhere('email','LIKE','%'.$request->searchData.'%')
            ->orWhere('last_name','LIKE','%'.$request->searchData.'%')
            ->orWhere('role','LIKE','%'.$request->searchData.'%')
          
            
            ->get();

            $searchUsersCount=User::orderBy('updated_at', 'desc')->where('first_name','LIKE','%'.$request->searchData.'%')
            ->orWhere('email','LIKE','%'.$request->searchData.'%')
            ->orWhere('last_name','LIKE','%'.$request->searchData.'%')
            ->orWhere('role','LIKE','%'.$request->searchData.'%')
            
            ->simplePaginate($usersPerPage);




            $pageCount = count($searchUsers) / $usersPerPage;




            return response()->json([
                'users' =>  $searchUsersCount,
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
