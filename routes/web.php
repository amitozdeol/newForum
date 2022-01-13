<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\FrontendController@index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/new-topic', function () {
    return view('client.new-topic');
});

Route::get('/category/overview/{id}', 'App\Http\Controllers\FrontendController@categoryOverview')->name('category.overview');

Route::get('/forum/overview/{id}', 'App\Http\Controllers\FrontendController@forumOverview')->name('forum.overview');

Route::get('dashboard/home', 'App\Http\Controllers\DashboardController@home')->middleware('isAdmin');

Route::get('dashboard/category/new', 'App\Http\Controllers\CategoryController@create')->name('category.new');
Route::post('dashboard/category/new', 'App\Http\Controllers\CategoryController@store')->name('category.store');
Route::get('dashboard/categories', 'App\Http\Controllers\CategoryController@index')->name('categories');
Route::get('dashboard/categories/{id}', 'App\Http\Controllers\CategoryController@show')->name('category');
Route::get('dashboard/categories/edit/{id}', 'App\Http\Controllers\CategoryController@edit')->name('category.edit');
Route::post('dashboard/categories/edit/{id}', 'App\Http\Controllers\CategoryController@update')->name('category.update');
Route::get('dashboard/categories/delete/{id}', 'App\Http\Controllers\CategoryController@destroy')->name('category.destroy');

//Forums
Route::get('dashboard/forum/new', 'App\Http\Controllers\ForumController@create')->name('forum.new');
Route::post('dashboard/forum/new', 'App\Http\Controllers\ForumController@store')->name('forum.store');
Route::get('dashboard/forums', 'App\Http\Controllers\ForumController@index')->name('forums');

Route::get('dashboard/forums/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum');
Route::get('dashboard/forums/edit/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum.edit');
Route::post('dashboard/forums/update/{id}', 'App\Http\Controllers\ForumController@update')->name('forum.update');
Route::get('dashboard/forums/delete/{id}', 'App\Http\Controllers\ForumController@destroy')->name('forum.destroy');


//Topics
Route::get('client/topic/new/{id}', 'App\Http\Controllers\DiscussionController@create')->name('topic.new');
Route::post('client/topic/new', 'App\Http\Controllers\DiscussionController@store')->name('topic.store');
Route::get('client/topic/{id}', 'App\Http\Controllers\DiscussionController@show')->name('topic');
Route::post('client/topic/reply/{id}', 'App\Http\Controllers\DiscussionController@reply')->name('topic.reply');
Route::get('/topic/reply/delete/{id}', 'App\Http\Controllers\DiscussionController@destroy')->name('reply.delete');

// Route::get('dashboard/forums', 'App\Http\Controllers\ForumController@index')->name('forums');

// Route::get('dashboard/forums/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum');
// Route::get('dashboard/forums/edit/{id}', 'App\Http\Controllers\ForumController@edit')->name('forum.edit');
// Route::post('dashboard/forums/update/{id}', 'App\Http\Controllers\ForumController@update')->name('forum.update');
// Route::get('dashboard/forums/delete/{id}', 'App\Http\Controllers\ForumController@destroy')->name('forum.destroy');


Route::get('/updates', 'App\Http\Controllers\DiscussionController@updates');
Route::post('user/update/{id}', 'App\Http\Controllers\UserController@update')->name("user.update");

//users

Route::get('/dashboard/users/{id}', 'App\Http\Controllers\DashboardController@show');
Route::post('/dashboard/users/{id}', 'App\Http\Controllers\DashboardController@destroy')->name('user.delete');

Route::prefix('admin')->group(function() {
    Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'Auth\AdminController@index')->name('admin.dashboard');
   }) ;
