<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;

Route::get('admin_login',[loginController::class,'admin_login'])->name('admin_login');


Route::group(['namespace'=>'App\Http\Controllers\Admin','middleware'=>'is_admin'],function(){
    
    Route::get('admin_home','AdminController@admin')->name('admin_home');
    Route::get('admin_logout','AdminController@logout')->name('admin_logout');

    //Category Routes.....

    Route::group(['prefix'=>'category'],function(){
        Route::get('/', 'CategoryController@index')->name('category_index');
        Route::post('/store', 'CategoryController@store')->name('category_store');
        Route::get('/delete/{id}', 'CategoryController@delete')->name('category_delete');
        Route::get('/edit/{id}', 'CategoryController@edit');
        Route::post('/update', 'CategoryController@update')->name('category_update');
    });
    //Subcategory Routes.....
    Route::group(['prefix'=>'subcategory'],function(){
        Route::get('/', 'SubcategoryController@index')->name('subcat_index');
        Route::post('/store', 'SubcategoryController@store')->name('subcategory_store');
        Route::get('/delete/{id}', 'SubcategoryController@delete')->name('subcat_delete');
        Route::get('/edit/{id}', 'SubcategoryController@edit');
        Route::post('/update/{id}', 'SubcategoryController@update')->name('subcategory_update');
    });

    //Childcategory Routes.....
    Route::group(['prefix'=>'childcategory'],function(){
        Route::get('/', 'ChildcategoryController@index')->name('childcat_index');
        Route::post('/store', 'ChildcategoryController@store')->name('childcategory_store');
        Route::get('/delete/{id}','ChildcategoryController@delete')->name('childcategory_delete');
        Route::get('/edit/{id}', 'ChildcategoryController@edit');
        Route::post('/update/{id}','ChildcategoryController@update')->name('childcategory_update');

    });
    //Brand Routes 
	Route::group(['prefix'=>'brand'], function(){
		Route::get('/','BrandController@index')->name('brand_index');
		Route::post('/store','BrandController@store')->name('brand_store');
		Route::get('/delete/{id}','BrandController@delete')->name('brand_delete');
		Route::get('/edit/{id}','BrandController@edit');
		Route::post('/update/{id}','BrandController@update')->name('brand_update');
	});
    //Coupon....
    Route::group(['prefix'=>'coupon'], function(){
		Route::get('/','CouponController@index')->name('coupon_index');
		Route::post('/store','CouponController@store')->name('coupon_store');
        Route::get('/delete/{id}','CouponController@delete')->name('coupon_delete');
        Route::get('/edit/{id}','CouponController@edit');
        Route::post('/update/{id}','CouponController@update')->name('coupon_update');
	});

});