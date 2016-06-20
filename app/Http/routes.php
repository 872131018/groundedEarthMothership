<?php
/*
* Load the request namespace for handling post
*/
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', function () {
  /*
  * Get all the images for the designs
  */
  $designs = scandir('./images/designs');
  foreach($designs as $index => $value) {
      switch($value) {
          case '.':
          case '..':
          case 'bird.png':
            unset($designs[$index]);
          default:
            continue;
      }
  }
  /*
  * Get all the images for the shirts
  */
  $mockups = scandir('./images/mockups');
  foreach($mockups as $index => $value) {
      switch($value) {
          case '.':
          case '..':
            unset($mockups[$index]);
          default:
            continue;
      }
  }

  return view('index', [
      'base_url' => getenv("APP_URL"),
      'designs' => $designs,
      'mockups' => $mockups
  ]);
});
/*
* Save the email through post
*/
Route::post('/inquiry', 'InquiryController@save');
/*
* Save a product through post
*/
Route::post('/products', 'ProductController@save');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/inquiries', 'InquiryController@index');
    Route::get('/products', 'ProductController@index');
});
