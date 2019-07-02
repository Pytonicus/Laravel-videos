<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Video;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/videos', function(){
    $videos = Video::all();
    foreach($videos as $video){
        echo $video->title . '<br>';
        echo $video->user->email . '<br>';

        foreach($video->comments as $comment){
            echo '- ' . $comment->body . '<hr>';
        }
    }
});
Route::auth();
Route::get('/', 'HomeController@index');

Route::get('/crear-video', array(
    'as' => 'createVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@createVideo'
));

Route::post('/guardar-video', array(
    'as' => 'saveVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@saveVideo'
));

Route::get('/miniatura/{filename}', array(
    'as' => 'imageVideo',
    'uses' => 'VideoController@getImage'
));

Route::get('/video/{video_id}', array(
    'as' => 'detailVideo',
    'uses' => 'VideoController@getVideoPage'
));

Route::get('/video-file/{filename}', array(
    'as' => 'fileVideo',
    'uses' => 'VideoController@getVideo'
));

Route::post('/comment', array(
    'as' => 'comment',
    'middleware' => 'auth', 
    'uses' => 'CommentController@store'
));

Route::get('/delete-comment/{comment_id}', array(
    'as' => 'commentDelete',
    'middleware' => 'auth',
    'uses' => 'CommentController@delete'
));

Route::get('/delete-video/{video_id}', array(
    'as' => 'videoDelete',
    'middleware' => 'auth',
    'uses' => 'VideoController@delete'
));

Route::get('/editar-video/{video_id}', array(
    'as' => 'videoEdit',
    'middleware' => 'auth',
    'uses' => 'VideoController@edit'
));

Route::post('/update-video/{video_id}', array(
    'as' => 'updateVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@update'
));

Route::get('/buscar/{search?}/{filter?}', [
    'as' => 'videoSearch',
    'uses' => 'VideoController@search'
]);

Route::get('/clear-cache', function(){
    $code = Artisan::call('cache:clear');
});

// Creamos la ruta a los canales:
Route::get('/canal/{user_id}', array(
    'as' => 'channel',
    'uses' => 'UserController@channel'
));