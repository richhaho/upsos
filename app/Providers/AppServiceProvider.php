<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Font;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;

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
        Schema::defaultStringLength(191);
        $data = PaymentGateway::whereKeyword('Stripe')->first();
        $paydata = $data->convertAutoData();
        Stripe::setApiKey($paydata['secret']);

        if ($this->app->environment('production') && DB::table('generalsettings')->first()->is_ssl == 1) {
            \URL::forceScheme('https');
        }

        view()->composer('*', function ($settings) {
            $paystack = PaymentGateway::whereKeyword('paystack')->first();
            $paystack = $paystack->convertAutoData();

            $categories = DB::table('categories')
                ->select([
                    'id',
                    'title',
                    'slug',
                    'color',
                    'photo',
                    'status',
                    DB::raw("'parent' as type"),
                    DB::raw("'' as category_id")
                ])
                ->where('status', 1);

            $subCategories = DB::table('subcategories')->select([
                'id',
                'title',
                'slug',
                DB::raw("'' as color"),
                DB::raw("image as photo"),
                DB::raw("'0' as status"),
                DB::raw("'child' as type"),
                'category_id',
            ]);
            $settings->with('categories', $subCategories->union($categories)->orderBy('id', 'DESC')->get());
            $settings->with('seo', DB::table('seotools')->first());
            $settings->with('paystackKey', $paystack['key']);
            $settings->with('gs', DB::table('generalsettings')->first());
            $settings->with('pages', DB::table('pages')->whereStatus(1)->get());
            $settings->with('ps', DB::table('pagesettings')->first());
            $settings->with('social', DB::table('socialsettings')->first());
            $settings->with('sociallinks', DB::table('social_links')->where('status', 1)->orderBy('id', 'desc')->get());
            $settings->with('default_font', Font::where('is_default', '=', 1)->first());
            $settings->with('defaultCurrency', globalCurrency());
            $settings->with('socialsetting', DB::table('socialsettings')->first());


            if (\Request::is('admin') || \Request::is('admin/*')) {
                $data = DB::table('admin_languages')->where('is_default', '=', 1)->first();
                App::setlocale($data->name);
            } else {

                if (Session::has('language')) {

                    $data = DB::table('languages')->find(Session::get('language'));
                    App::setlocale($data->name);
                } else {
                    $data = DB::table('languages')->where('is_default', '=', 1)->first();
                    App::setlocale($data->name);
                }
            }

            $settings->with('online_service_status', isOnlineService());
        });




    }




}

