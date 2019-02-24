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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function(){

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('tickets', 'TicketController');
    Route::post('/tickets/{ticket}/assign', 'TicketController@assign')->name('tickets.assign');
    Route::post('/tickets/{ticket}/close', 'TicketController@close')->name('tickets.close');

    Route::post('/tickets/{ticket}/comments/create', 'CommentController@store')->name('tickets.comments.create');

    Route::post('/attachments/{attachment}/download', 'AttachmentController@download')->name('attachment.download');
    Route::post('/tickets/{ticket}/attachments/upload', 'AttachmentController@upload')->name('attachment.upload');

});


