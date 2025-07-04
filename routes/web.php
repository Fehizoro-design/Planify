<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('tasks.index'); // Nous allons créer cette vue
});
