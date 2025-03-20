<?php

namespace src\controllers;

use src\core\Controller;

class ExampleController extends Controller
{

    function __construct() {}

    public function index()
    {
        dd('this is example controller');
    }
}
