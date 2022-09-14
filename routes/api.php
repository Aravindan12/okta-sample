<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Okta\JwtVerifier\Adaptors\FirebasePhpJwt;
use Okta\JwtVerifier\JwtVerifierBuilder;

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

Route::middleware(['auth:sanctum'])->get('/users', function (Request $request) {

    $jwtVerifier = (new JwtVerifierBuilder())
            ->setAdaptor(new FirebasePhpJwt())
            ->setAudience('api://default')
            ->setClientId('0oa6hvtje6MkQzZbG5d7')
            ->setIssuer('https://dev-62008175.okta.com/oauth2/default')
            ->build();
    return $jwtVerifier->toJson();
});

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});