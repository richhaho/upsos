<?php
use App\Http\Controllers;
use App\Http\Controllers\User\SocialRegisterController;
use Illuminate\Support\Facades\Route;

Route::redirect('admin', 'admin/login');
Route::post('the/genius/ocean/2441139', 'Frontend\FrontendController@subscription');
Route::get('finalize', 'Frontend\FrontendController@finalize');

Route::get('/under-maintenance', 'Frontend\FrontendController@maintenance')->name('front-maintenance');
Route::group(['middleware' => 'maintenance'], function () {
  Route::get('/', 'Frontend\FrontendController@index')->name('front.index');
  Route::post('/online-service-switcher', 'Frontend\FrontendController@updateOnlineServiceStatus')->name('front.updateOnlineServiceStatus');

  Route::get('blogs', 'Frontend\FrontendController@blog')->name('front.blog');
  Route::get('blog/{slug}', 'Frontend\FrontendController@blogdetails')->name('blog.details');
  Route::get('/blog-search', 'Frontend\FrontendController@blogsearch')->name('front.blogsearch');
  Route::get('/blog/category/{slug}', 'Frontend\FrontendController@blogcategory')->name('front.blogcategory');
  Route::get('/blog/tag/{slug}', 'Frontend\FrontendController@blogtags')->name('front.blogtags');


  Route::get('/plans', 'Frontend\FrontendController@plans')->name('front.plans');
  Route::get('/plan/{slug}', 'Frontend\FrontendController@plan')->name('front.plan');

  Route::get('/about', 'Frontend\FrontendController@about')->name('front.about');
  Route::group(['middleware' => ['auth']], function () {
    Route::get('/contact', 'Frontend\FrontendController@contact')->name('front.contact');
    Route::get('resume/{username}', 'Frontend\ProfileController@resume')->name('front.resume');
  });


  Route::post('/contact', 'Frontend\FrontendController@contactemail')->name('front.contact.submit');
  Route::get('/faq', 'Frontend\FrontendController@faq')->name('front.faq');
  Route::get('/{slug}', 'Frontend\FrontendController@page')->name('front.page');
  Route::post('/subscriber', 'Frontend\FrontendController@subscriber')->name('front.subscriber');

  Route::post('/profit/calculate', 'Frontend\FrontendController@calculate')->name('front.profit.calculate');

  Route::get('/currency/{id}', 'Frontend\FrontendController@currency')->name('front.currency');
  Route::get('/language/{id}', 'Frontend\FrontendController@language')->name('front.language');

  Route::get('/all/jobs', 'Frontend\FrontendController@alljobs')->name('front.alljobs');
  Route::get('/job/{slug}', 'Frontend\FrontendController@jobdetails')->name('front.jobdetails');
  Route::post('/service/review/store', 'Frontend\FrontendController@servicereview')->name('front.servicereview');

  Route::get('/all/services', 'Frontend\FrontendController@allservices')->name('front.allservices');
  Route::get('/service/{slug}', 'Frontend\FrontendController@servicedetails')->name('front.servicedetails');
  Route::get('/service/category/{slug}', 'Frontend\FrontendController@servicecategory')->name('front.servicecategory');
  Route::get('/service/location/search', 'Frontend\FrontendController@servicesearch')->name('front.servicesearch');

  Route::get('/currency/{id}', 'Frontend\FrontendController@currency')->name('front.currency');
  Route::get('/language/{id}', 'Frontend\FrontendController@language')->name('front.language');

  Route::post('/cities', 'Frontend\FrontendController@getCities')->name('front.cities');
  Route::post('/areas', 'Frontend\FrontendController@getAreas')->name('front.areas');

});
Route::get('auth/{provider}', [SocialRegisterController::class, 'redirectToProvider'])->name('social-provider');
Route::get('auth/{provider}/callback', [SocialRegisterController::class, 'handleProviderCallback']);

