<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
 */

Route::post('login', 'Api\AuthController@login');
Route::post('logout/{user}', 'Api\AuthController@logout');

/*
|--------------------------------------------------------------------------
| ALL ROUTS
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => 'auth:sanctum'], static function () {
  Route::resource('vacation', 'Api\VacationController');

  Route::put('vacation/fixed/{vacation}', 'Api\VacationController@fixed');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

