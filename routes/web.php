<?php

use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('frontend.index');
// });
Route::get('/login',function(){
    return redirect()->to('/');
})->name('login');

Route::get('/pruduct_details', function () {
    return view('frontend.product_details');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/customer/logout', [App\Http\Controllers\HomeController::class,'logout'])->name('customer.logout');

Route::group(['namespace'=>'App\Http\Controllers\Fornt'],function(){

    Route::get('/','IndexController@index');
    Route::get('/product/details/{slug}','IndexController@product_details')->name('product_details');
});   