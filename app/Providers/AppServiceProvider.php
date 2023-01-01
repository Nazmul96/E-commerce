<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $settings=DB::table('website_settings')->first();
        $pages_one=DB::table('pages')->where('page_position',1)->get();
        $pages_two=DB::table('pages')->where('page_position',2)->get();

        view()->share('setting',$settings);
        view()->share('pages_one',$pages_one);
        view()->share('pages_two',$pages_two);
    }
}
