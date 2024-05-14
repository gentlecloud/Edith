<?php
use Illuminate\Support\Facades\Route;

Route::get('edith/init', 'App\Edith\Controllers\EdithController@init')->name('api/edith/init');

\Edith\Admin\Facades\Edith::routes();