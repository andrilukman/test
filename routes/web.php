<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//routes function 
// $router->get($uri, $callback);
// $router->post($uri, $callback);
// $router->put($uri, $callback);
// $router->patch($uri, $callback);
// $router->delete($uri, $callback);
// $router->options($uri, $callback);

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Konfigurasi Key
$router->get('/key', function(){
    return \Illuminate\Support\Str::random(32);
});

//Latihan router
$router->get('/test', function(){
    return 'Hello, saya uji coba';
});

//router dengan parameter
$router->get('/test/{id}/comments/{commentsId}', function($id, $commentsId){
    return 'Id = '.$id.' Comments Id = '.$commentsId;
});

//router dengan parameter optional
$router->get('/test/comments[/{default}]', function($default = null){
    return $default;
});

//router alias
$router->get('profile/test', ['as' => 'route.profile', function(){
    //URL Routes
    //return route('route.profile');
    return 'Hai, ini route alias';
}]);

//redirect to URL alias
$router->get('profile', function(){
    return redirect()->route('route.profile');
});

//grouping route
//'middleware' => 'auth' masuk dengan izin autentifikasi
//'namespace' membuat folder khusus diluar lumen
$router->group(['prefix' => 'admin', 'middleware' => 'age'], function () use ($router) {
    $router->get('home', function(){
        return 'Home Admin';
    });

    $router->get('profile', function(){
        return 'Profile Admin';
    });
});

//http://localhost:8000/admin/home?age=18
//middleware tidak sesuai pada autentifikasi age
$router->get('/fail', function(){
    return 'Error: 202';
});

//Route ke Controller
$router->get('/test2', 'ExampleController@testController');

//Route kirim parameter ke Controller
$router->get('/user/{id}', 'ExampleController@getUser');

//Alias route pada Controller
$router->get('/data_user', ['as' => 'user', 'uses' => 'ExampleController@getDataUser']);
$router->get('/data_profile', ['as' => 'profile', 'uses' => 'ExampleController@getDataProfile']);

//Middleware dalam Controller
$router->group(['prefix' => 'customers', 'middleware' => 'age', 'logroute'], function () use ($router) {
    $router->get('home', 'ExampleController@getHome');

    $router->get('profile', function(){
        return 'Profile Customers';
    });   
});

//Handler Http request
$router->get('handleRequest', 'ExampleController@handleRequest');
$router->get('handleRequest2', 'ExampleController@handleRequest');

//mengambil nilai request
$router->get('form_view', function(){
    return view('viewTest');
});

$router->post("testView", 'ExampleController@formView');

$router->get('/response', 'ExampleController@response');

//authentication
//$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');

$router->group(['prefix' => 'test', 'middleware' => 'logroute'], function () use ($router) {
    $router->get('register', 'ExampleController@testController');

    $router->get('profile', function(){
        return 'Profile Customers';
    });   
});
