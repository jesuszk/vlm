<?php

namespace src\routes;

use src\controllers\ProductController;
use src\core\Route;


Route::get('/products', ProductController::class, 'index')->name('products.index');
Route::get('/products/create', ProductController::class, 'create')->name('products.create');
Route::post('/products/store', ProductController::class, 'store')->name('products.store');


Route::get('/{uuidv1}/{uuidv2}', ProductController::class, 'varios')
    ->name('varios')
    ->where([
        'uuidv1' => 'uuid',
        'uuidv2' => 'uuid',
    ]);
