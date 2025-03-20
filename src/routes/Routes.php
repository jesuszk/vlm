<?php

namespace src\routes;

use src\controllers\ExampleController;

$r = new Router;

$r->get('/', ExampleController::class, 'index');

return $r->init();
