<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Okta\JwtVerifier\Adaptors\FirebasePhpJwt;
use Okta\JwtVerifier\JwtVerifierBuilder;
require_once("../vendor/autoload.php"); // This should be replaced with your path to your vendor/autoload.php file

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/users', function (Request $request) {

    $jwtVerifier = (new JwtVerifierBuilder())
            ->setAdaptor(new FirebasePhpJwt())
            ->setAudience('api://default')
            ->setClientId('0oa6hvtje6MkQzZbG5d7')
            ->setIssuer('https://dev-62008175.okta.com/oauth2/default')
            ->build();
    return $jwtVerifier->toJson();
});

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('login', [\App\Http\Controllers\AuthController::class,'login']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class,'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class,'refresh']);
    Route::post('me', [\App\Http\Controllers\AuthController::class,'me']);

});
