<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController as HomeController;
use App\Http\Controllers\Web\CustomerAuthController as CustomerAuth;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('web.index');
// });




Route::prefix('customer')->name('customer.')->group(function () {
  


  Route::get('home', [HomeController::class, 'home'])->name('customer.home');

  Route::get('signupuser', [CustomerAuth::class, 'signupuser'])->name('signupuser');
  Route::match(['get', 'post'], 'signup', [CustomerAuth::class, 'signupPost'])->name('customer.signup');

  Route::get('loginuser', [CustomerAuth::class, 'loginuser'])->name('loginuser'); 
  Route::match(['get', 'post'], 'login', [CustomerAuth::class, 'loginPost'])->name('customer.login');

        

  


  Route::get('verify', [CustomerAuth::class, 'verify'])->name('verify');

  Route::post('verify_post', [CustomerAuth::class, 'verify_post'])->name('verify_post');

  
  Route::get('booking', [CustomerAuth::class, 'booking'])->name('booking');

  Route::post('booking_add', [CustomerAuth::class, 'booking_add'])->name('booking_add');



});





