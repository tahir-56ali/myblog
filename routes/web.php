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

use App\Country;
use App\Photos;
use App\Post;
use App\User;
use App\UserPhoto;
use App\UserPosts;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function () {
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
    Post::find(5)->delete();
});

/*Eloquent ORM read soft deletes*/
Route::get('/readsoftdeletes', function () {
    //$posts = Post::withTrashed()->get(); // all posts with including trashed as well
    $posts = Post::onlyTrashed()->get(); // only trashed posts
    return $posts;
});

/*Eloquent ORM restore soft deletes*/
Route::get('/restoresoftdelete', function () {
    //Post::onlyTrashed()->restore(); // restore all trashed posts
    Post::where('id', 1)->restore(); // restore particular post
});

/*Eloquent ORM force delete (permanently)*/
Route::get('/forcedelete', function () {
    Post::onlyTrashed()->where('user_id', 1)->forceDelete();
});

/*Eloquent ORM one to one relationship */
Route::get('/user/{id}/photo', function ($id) {
    $user = User::find($id);
    return $user->photo;
});

/*Eloquent ORM one to one inverse relationship */
Route::get('/post/{id}/user', function ($id) {
    $post = Post::find($id);
    return $post->user;
});

/*Eloquent ORM one to many relationship */
Route::get('/user/{id}/posts', function ($id) {
    $user = User::find($id);
    foreach ($user->posts as $post) {
        echo $post->title . '<br>';
    }
});

/*Eloquent ORM many to many relationship */
Route::get('/user/{id}/roles', function ($id) {
    $user = User::find($id)->roles()->orderby('id', 'asc')->get();
    return $user;
    foreach ($user->roles as $role) {
        echo $role->name . '<br>';
    }
});

/*Eloquent ORM querying pivot/intermediate table */
Route::get('/user/pivot', function () {
    $user = User::find(1);

    foreach ($user->roles as $role) {
        echo $role->pivot->created_at . '<br>';
    }
});

/*Eloquent ORM Has Many Through relation */
Route::get('/user/country', function () {
    $country = Country::find(2);

    foreach ($country->posts as $post) {
        return $post->title;
    }
});

/* Eloquent ORM Polymorphic one to many relation */
Route::get('/user/{id}/photos', function ($id) {
    $user = User::find($id);

    foreach ($user->photos as $photo) {
        echo $photo->path . '<br>';
    }
});

/* Eloquent ORM Polymorphic one to many relation */
Route::get('/post/{id}/photos', function ($id) {
    $userPosts = UserPosts::find($id);

    foreach ($userPosts->photos as $photo) {
        echo $photo->path . '<br>';
    }
});

/* Eloquent ORM Polymorphic one to many inverse relation */
Route::get('/userphotos/{id}', function ($id) {
    $userPhoto = UserPhoto::find($id);
    return $userPhoto->imageable;

});