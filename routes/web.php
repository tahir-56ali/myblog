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

use App\Post;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function(){
   return view('admin.index');
});

Route::group(['middleware' => 'admin'], function () {

    Route::resource('admin/users', 'AdminUsersController');

    Route::resource('admin/posts', 'AdminPostsController');

    Route::resource('admin/categories', 'AdminCategoriesController');

    Route::resource('admin/media', 'AdminMediasController');

});

/*inserting data using raw sql query*/
Route::get('/insertraw', function () {
    DB::insert('insert into posts (user_id, category_id, photo_id, title, body) values (?, ?, ?, ?, ?)', [1, 1, 1, 'testing post', 'testing body']);
});

/*reading data using raw sql query*/
Route::get('/readraw', function () {
    $results = DB::select('select * from posts where id = ?', [1]);
    dd($results);
});

/*updating data using raw sql query*/
Route::get('/updateraw', function () {
    $affected = DB::update('update posts set title=?,body=? where id=?', ['testing title updated', 'testing body updated', 6]);
    return $affected;
});

/*deleting data using raw sql query*/
Route::get('/deleteraw', function () {
    $deleted = DB::delete('delete from posts where id=?', [6]);
    return $deleted;
});

/*Eloquent ORM read*/
Route::get('/readorm', function () {
    $posts = Post::all();
    foreach ($posts as $post) {
        return $post->title;
    }
});

/*Eloquent ORM find*/
Route::get('/findorm', function () {
    $post = Post::find(1);
    return $post->title;
});

/*Eloquent ORM findwhere*/
Route::get('/findwhere', function () {
    $post = Post::where('id', 1)->orderBy('id', 'desc')->take(1)->get();
    return $post;
});

/*Eloquent ORM findmore*/
Route::get('/findmore', function () {
    //$posts = Post::findOrFail(1);
    $posts = Post::where('id', 1)->firstOrFail();
    return $posts;
});

/*Eloquent ORM soft delete*/
Route::get('/softdelete', function () {
    Post::find(1)->delete();
});

/*Eloquent ORM read soft deletes*/
Route::get('/readsoftdeletes', function() {
   //$posts = Post::withTrashed()->get(); // all posts with including trashed as well
    $posts = Post::onlyTrashed()->get(); // only trashed posts
   return $posts;
});

/*Eloquent ORM restore soft deletes*/
Route::get('/restore', function() {
   //Post::withTrashed()->restore(); // restore all trashed posts
    Post::where('id', 1)->restore(); // restore particular post
});

/*Eloquent ORM force delete (permanently)*/
Route::get('/forcedelete', function() {
    Post::onlyTrashed()->where('user_id', 1)->forceDelete();
});