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

    //global route
	Route::get('/get-child-category/{id}','CategoryController@GetChildCategory');

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
    //Brand Routes..... 
	Route::group(['prefix'=>'brand'], function(){
		Route::get('/','BrandController@index')->name('brand_index');
		Route::post('/store','BrandController@store')->name('brand_store');
		Route::get('/delete/{id}','BrandController@delete')->name('brand_delete');
		Route::get('/edit/{id}','BrandController@edit');
		Route::post('/update/{id}','BrandController@update')->name('brand_update');
	});

    //Warehouse Routes.....
    Route::group(['prefix'=>'warehouse'], function(){
		Route::get('/','WarehouseController@index')->name('warehouse_index');
		Route::post('/store','WarehouseController@store')->name('warehouse_store');
		Route::get('/delete/{id}','WarehouseController@delete')->name('warehouse_delete');
		Route::get('/edit/{id}','WarehouseController@edit');
		Route::post('/update/{id}','WarehouseController@update')->name('warehouse_update');
	});

    
    //product Routes..... 
	Route::group(['prefix'=>'product'], function(){
        Route::get('/','ProductController@index')->name('product_index');
		Route::get('/create','ProductController@create')->name('product_create');
		Route::post('/store','ProductController@store')->name('product_store');
		Route::get('/delete/{id}','ProductController@product_delete')->name('product_delete');
		Route::get('/edit/{id}','ProductController@edit')->name('product.edit');
		Route::post('/update','ProductController@update')->name('product.update');
        
        Route::get('/featured-active/{id}','ProductController@featured_active');
        Route::get('/featured-deactive/{id}','ProductController@featured_deactive');
        Route::get('/todaydeal-active/{id}','ProductController@todaydeal_active');
        Route::get('/todaydeal-deactive/{id}','ProductController@todaydeal_deactive');
        Route::get('/status-active/{id}','ProductController@status_active');
        Route::get('/status-deactive/{id}','ProductController@status_deactive');
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

        //payment-gateway setting
		Route::group(['prefix'=>'payment-gateway'], function(){
			Route::get('/','SettingController@PaymentGateway')->name('payment.gateway');
			Route::post('/update-aamarpay','SettingController@AamarpayUpdate')->name('update.aamarpay');
			Route::post('/update-surjopay','SettingController@SurjopayUpdate')->name('update.surjopay');
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
        Route::delete('/delete/{id}','CouponController@delete')->name('coupon_delete');
        Route::get('/edit/{id}','CouponController@edit');
        Route::post('/update/{id}','CouponController@update')->name('coupon_update');
	});

    //Campaign.....................
    Route::group(['prefix'=>'campaign'], function(){
    Route::get('/','CampignController@index')->name('campaign.index');
    Route::post('/store','CampignController@store')->name('campaign.store');
    Route::get('/delete/{id}','CampignController@delete')->name('campaign.delete');
    Route::get('/edit/{id}','CampignController@edit');
    Route::post('/update','CampignController@update')->name('campaign.update');
   });

   //__campaign product routes__//
	Route::group(['prefix'=>'campaign-product'], function(){
		Route::get('/{campaign_id}','CampaignProductController@campaignProduct')->name('campaign.product');
		Route::get('/add/{id}/{campaign_id}','CampaignProductController@ProductAddToCampaign')->name('add.product.to.campaign');
		Route::get('/list/{campaign_id}','CampaignProductController@ProductListCampaign')->name('campaign.product.list');
		Route::get('/remove/{id}','CampaignProductController@RemoveProduct')->name('product.remove.campaign');
		// Route::post('/update','CampaignController@update')->name('campaign.update');
	});

    //__order 
    Route::group(['prefix'=>'order'], function(){
        Route::get('/','OrderController@index')->name('admin.order.index');
        Route::get('/admin/edit/{id}','OrderController@Editorder');
        Route::post('/update/order/status','OrderController@updateStatus')->name('update.order.status');
        Route::get('/admin/view/{id}','OrderController@ViewOrder');
        Route::get('/delete/{id}','OrderController@delete')->name('order.delete');
            
    });
    //pickup point....
    Route::group(['prefix'=>'pickup-point'], function(){
		Route::get('/','PickupController@index')->name('pickup_point_index');
		Route::post('/store','PickupController@store')->name('pickup_point_store');
        Route::get('/delete/{id}','PickupController@delete')->name('pickup_point_delete');
        Route::get('/edit/{id}','PickupController@edit')->name('pickup_point_edit');;
        Route::post('/update/{id}','PickupController@update')->name('pickup_point_update');
	});

    //Ticket 
    Route::group(['prefix'=>'ticket'], function(){
    Route::get('/','TicketController@index')->name('ticket.index');
    Route::get('/ticket/show/{id}','TicketController@show')->name('admin.ticket.show');
    Route::post('/ticket/reply','TicketController@ReplyTicket')->name('admin.store.reply');
    Route::get('/ticket/close/{id}','TicketController@CloseTicket')->name('admin.close.ticket');
    Route::delete('/ticket/delete/{id}','TicketController@destroy')->name('admin.ticket.delete');
    });

    //Blog category
    Route::group(['prefix'=>'blog-category'], function(){
    Route::get('/','BlogController@index')->name('admin.blog.category');
    Route::post('/store','BlogController@store')->name('blog.category.store');
    Route::get('/delete/{id}','BlogController@destroy')->name('blog.category.delete');
    Route::get('/edit/{id}','BlogController@edit');
    Route::post('/update','BlogController@update')->name('blog.category.update');
    });

    //__role create__
    Route::group(['prefix'=>'role'], function(){
        Route::get('/','RoleController@index')->name('manage.role');
        Route::get('/create','RoleController@create')->name('create.role');
        Route::post('/store','RoleController@store')->name('store.role');
        Route::get('/delete/{id}','RoleController@destroy')->name('role.delete');
        Route::get('/edit/{id}','RoleController@edit')->name('role.edit');
        Route::post('/update','RoleController@update')->name('update.role');
    });

    //__report routes__//
    Route::group(['prefix'=>'report'], function(){
        Route::get('/order','ReportController@ReportOrderindex')->name('report.order.index');
        Route::get('/order/print','ReportController@ReportOrderPrint')->name('report.order.print');
    });
});