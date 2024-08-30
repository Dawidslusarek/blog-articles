<?php

use App\Http\Controllers\Auth\CreateAccessTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/token/create', [CreateAccessTokenController::class, 'create']);
