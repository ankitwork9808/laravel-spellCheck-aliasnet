<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Open Routes */
Route::group(['prefix' => 'V1'], function ()
{
    Route::post('/getToken', [ApiController::class, 'getToken']);
});

//auth:sanctum
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'V1'], function ()
{
    Route::post('/spellCheck', [ApiController::class, 'spellCheck']);

    Route::post('/getDifferences', [ApiController::class, 'getDifferences']);
});