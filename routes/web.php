<?php

use  App\Http\Controllers\HomeController;
use  App\Http\Controllers\AboutController;
use  App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
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

// Route::get('/', function () {
//     return view('home.index');
// })->name('home.index');

// Route::get('/contacts', function() {
//     return view('home.contact');
// })->name('home.contacts');

// Route::view('/','home.index')->name('home.index');
// Route::view('/contacts','home.contact')->name('home.contacts');


Route::get('/',[HomeController::class, 'home'])->name('home.index');
Route::get('/contacts',[HomeController::class, 'contact'])->name('home.contacts');

// Route::get('/single',AboutController::class)->name('home.index');

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true,
        'has_comments' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false
    ],
    3 => [
        'title' => 'Intro to Golang',
        'content' => 'This is a short intro to Golang',
        'is_new' => false
    ]
];

// Route::get('/posts',function() use($posts) {
//     return view('posts.index', [ 'posts'=> $posts]);
// });



// Route::get('/posts',function() use($posts) {
//     // dd(request()->all());
//     dd((int) request()->query('page', 1));
//     //compact($posts) = ['posts' => $posts])
//     return view('posts.index', [ 'posts'=> $posts]);
// });

// Route::get('/posts/{id}',function($id) use($posts) {   //annonymous function
//     abort_if(!isset($posts[$id]), 404);

//     return view('posts.show', [ 'posts'=>$posts[$id] ]);   //pass blogpost data to a given id
// })
// // ->where([
// //     'id'=>'[0-9]+'
// // ])
// ->name('posts.show');

Route::resource('posts', PostsController::class);
//->only(['index', 'show', 'create', 'store', 'edit', 'update']);


Route::get('/recent-posts/{days_ago?}', function ($days_ago = 20){
    return 'Posts from '. $days_ago . ' days ago';
})->name('posts.recent.index')->middleware('auth');  //user need to be authenticates to use this route now



Route::prefix('/fun')->name('fun.')->group(function()  use($posts) {

    Route::get('/responses', function() use($posts) {
        return response($posts, 201)
        ->header('Content-Type', 'application/json')
        ->cookie('MY_COOKIE', 'Hasandi', 3600 );
    })->name('response');
    
    Route::get('/redirect', function (){
        return redirect('/contacts');
    })->name('redirect');
    
    Route::get('/back', function (){
        return back();
    })->name('back');
    
    Route::get('/named-route', function () {
        return redirect()->route('posts.show', ['id' => 2]);
    })->name('named-route');
    
    Route::get('/away', function () {
        return redirect()->away('http://Google.com');
    })->name('away');
    
    Route::get('/json', function () use($posts) {
        return response()->json($posts);
    })->name('json');
    
    Route::get('/download', function () use($posts) {
        return response()->download(public_path('/daniel.jpg'), 'face.jpg');
    })->name('download');
});