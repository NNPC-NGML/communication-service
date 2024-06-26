<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('scope.user')->group(function () {
    Route::get('/protected', function () {
        return response()->json(['message' => 'Access granted']);
    });
});

Route::get('/email-template', function(){
    return view('emails.message', [
        'title' => "Hello,  Dangote Cement!",
        'message' => "Your application has been approved and is awaiting pending confirmation, please kindly exercise some patience while your issues has been addressed properly. Thank you!.",
        'appName' => config('app.name'),
        'websiteUrl' => 'https://website.com',
        'logoUrl' => 'https://firebasestorage.googleapis.com/v0/b/server-sec5.appspot.com/o/nnpc-logo.png?alt=media',
        'supportMail' => 'support@mail.com',
    ]);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
