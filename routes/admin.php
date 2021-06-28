<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;

Route::get('admin_login',[loginController::class,'admin_login'])->name('admin_login');


Route::group(['namespace'=>'App\Http\Controllers\Admin','middleware'=>'is_admin'],function(){
    
    Route::get('admin_home','AdminController@admin')->name('admin_home');
    Route::get('admin_logout','AdminController@logout')->name('admin_logout');
    Route::get('admin_password_change','AdminController@passwordchange')->name('admin_password_change');
    Route::post('admin_password_update','AdminController@passwordUpdate')->name('admin_password_update');

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

    //setting Routes..... 
	Route::group(['prefix'=>'setting'], function(){
        //seo setting....
		Route::group(['prefix'=>'seo'], function(){
            Route::get('/','SettingController@seo')->name('seo_setting');
            Route::post('update/{id}','SettingController@seoupdate')->name('seo_setting_update');
        });

        //smtp settng......
        Route::group(['prefix'=>'smtp'], function(){
            Route::get('/','SettingController@smtp')->name('smtp_setting');
            Route::post('update/{id}','SettingController@smtpupdate')->name('smtp_setting_update');
        });
        //website settng......
        Route::group(['prefix'=>'website'], function(){
            Route::get('/','SettingController@website_setting')->name('website_setting');
            Route::post('/update/{id}','SettingController@website_setting_update')->name('website_setting_update');
        });

        //page setting.......
        Route::group(['prefix'=>'page'], function(){
            Route::get('/','PageController@index')->name('page_index');
            Route::get('/create','PageController@create')->name('page_create');
            Route::post('/store','PageController@store')->name('page_store');
            Route::get('/delete/{id}','PageController@pagedelete')->name('page_delete');
            Route::get('/edit/{id}','PageController@page_edit')->name('page_edit');
            Route::post('/update/{id}','PageController@page_update')->name('page_update');
        });

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