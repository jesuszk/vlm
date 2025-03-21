<?php

namespace src\routes;

use src\controllers\ExampleController;
use src\core\Route;
use src\middlewares\IsLoggedMiddleware;

Route::get('/', ExampleController::class, 'index')->middlewares([IsLoggedMiddleware::class])->name('example.index');
Route::get('/save', ExampleController::class, 'save')->middlewares([IsLoggedMiddleware::class])->name('example.save');
Route::get('/blog/post/show/{id}', ExampleController::class, 'byId')->middlewares([IsLoggedMiddleware::class])->name('blog.post.byid')->whereInt('id');
Route::get('/blog/post/{slug}', ExampleController::class, 'view')->middlewares([IsLoggedMiddleware::class])->name('blog.post.view')->whereString(['slug']);
Route::get('/user/profile/{id}', ExampleController::class, 'profile')->middlewares([IsLoggedMiddleware::class])->name('user.profile.view')->whereInt('id');
Route::get('/rota/mais/de/{number}/parametros/{param}/novo/{novo}', ExampleController::class, 'manyParams')
    ->name('rota.varios.parametros')->where(['number' => 'int', 'param' => 'string', 'novo' => 'string']);

Route::get('/uuid/{uuid}', ExampleController::class, 'uuid')->name('uuid')->whereUuid('uuid');
