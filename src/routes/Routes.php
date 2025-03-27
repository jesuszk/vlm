<?php

namespace src\routes;

use src\controllers\ProductController;
use src\core\Route;
use src\middlewares\IsLoggedMiddleware;

Route::get('/products', ProductController::class, 'index')->name('products.index')->middlewares([IsLoggedMiddleware::class]);
Route::get('/products/create', ProductController::class, 'create')->name('products.create');
Route::post('/products/store', ProductController::class, 'store')->name('products.store');
Route::get('/products/edit/{id}', ProductController::class, 'edit')->name('products.edit')->whereInt('id')->middlewares([IsLoggedMiddleware::class]);
Route::post('/products/update/{id}', ProductController::class, 'update')->name('products.update')->whereInt('id');
Route::get('/products/delete/{uuid}/{name}', ProductController::class, 'delete')->name('products.delete')->whereUuid('uuid');
