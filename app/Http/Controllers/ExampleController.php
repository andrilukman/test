<?php

namespace App\Http\Controllers;

use Log;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Middleware untuk methode terpilih
        $this->middleware('age', ['only' => ['getHome']]);
        $this->middleware('logroute');
        
        //Middleware untuk semua methode kecuali methode terpilih
        //$this->middleware('age', ['except' => ['getDataUser']]);

        //Middleware untuk semua methode
        //$this->middleware('age');
    }

    //

    public function testController(){
        return 'Test Berhasil';
    }

    public function getUser($id){
        return 'User Id = '.$id;
    }

    public function getDataUser(){
        echo '<a href="'.route('profile').'">Profile Action</a>';
        //return route('user');
    }

    public function getDataProfile(){
        return route('user');
    }

    public function getHome(){
        return route('user'); 
    }

    public function handleRequest(Request $request){
        if($request->is('handleRequest')){
            return 'Success';
        }
        else{
            return 'Fail';
        }
        //return $request->path();
        //return $request->method();
    } 
    
    public function formView(Request $request){
        // return $request->all();
        //return $request->name;

        $user['name'] = $request->name;
        $user['username'] = $request->username;
        $user['password'] = $request->password;

        return $user;
    }

    public function response(){
        // $data['status']='Success';
        // return (new Response($data, 201))
        //     ->header('Content-Type', 'application/json');
      
        return response()->json([
            'message' => 'fail not found!',
            'status' => false
        ], 404);
        
    }
}
