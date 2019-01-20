<?php

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

Route::group(['middleware'=>'web'],function () {
  Route::match(['GET','POST'],'/',['uses'=>'IndexController@execute','as'=>'main']);
  Route::get('/page/{alias}',['uses'=>'PageController@execute','as'=>'page']);

  Route::auth();
});

Route::group(['prefix'=>'admin','middleware'=>'auth'], function () {
  Route::get('/', function () {
    if(view()->exists('admin.index')) {
      $data = ['title'=>'Панель администратора'];

      return view('admin.index', $data);
    }
  });

  Route::group(['prefix'=>'pages'],function () {
    Route::get('/',['uses'=>'PagesController@execute','as'=>'pages']);
    Route::match(['GET','POST'],'/add',['uses'=>'PagesAddController@execute','as'=>'pagesAdd']);
    Route::match(['GET','POST','DELETE'],'/edit/{page}',['uses'=>'PagesEditController@execute','as'=>'pagesEdit']);
  });

  Route::group(['prefix'=>'portfolios'],function () {
    Route::get('/',['uses'=>'PortfolioController@execute','as'=>'portfolios']);
    Route::match(['GET','POST'],'/add',['uses'=>'PortfolioAddController@execute','as'=>'portfolioAdd']);
    Route::match(['GET','POST','DELETE'],'/edit/{portfolio}',['uses'=>'PortfolioEditController@execute','as'=>'portfolioEdit']);
  });

  Route::group(['prefix'=>'services'],function () {
    Route::get('/',['uses'=>'ServiceController@execute','as'=>'services']);
    Route::match(['GET','POST'],'/add',['uses'=>'ServiceAddController@execute','as'=>'serviceAdd']);
    Route::match(['GET','POST','DELETE'],'/edit/{service}',['uses'=>'ServiceEditController@execute','as'=>'serviceEdit']);
  });
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
