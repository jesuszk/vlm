<?php

namespace src\routes;

use src\controllers\ProductController;
use src\core\Route;

Route::get('/products', ProductController::class, 'index')->name('products.index');
Route::post('/products/store', ProductController::class, 'store')->name('products.store');
Route::get('/products/edit/{uuid}', ProductController::class, 'edit')->name('products.edit')->whereUuid('uuid');
Route::get('/products/delete/{uuid}', ProductController::class, 'delete')->name('products.delete')->whereUuid('uuid');

