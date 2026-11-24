<?php

use App\Http\Controllers\ListController;

Route::get('/', [ListController::class, 'index']);

