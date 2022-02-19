<?php

use App\Http\Controllers\API\ConnectionController;
use App\Http\Controllers\API\V1\V1FileController;
use App\Http\Controllers\API\V1\V1CaseController;
use App\Http\Controllers\API\V1\ApiController;
use App\Http\Controllers\API\V1\V1LeadController;
use Illuminate\Support\Facades\Route;

/* Open Routes */
Route::group(['prefix' => 'V1'], function ()
{
    Route::post('/getToken', [ApiController::class, 'getToken']);
});

//auth:sanctum
Route::group(['middleware' => ['api.auth'], 'prefix' => 'V1'], function ()
{
    Route::post('/spellCheck', [ApiController::class, 'spellCheck']);

    Route::post('/getDifferences', [ApiController::class, 'getDifferences']);
});