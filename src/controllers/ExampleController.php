<?php

namespace src\controllers;

use src\core\Controller;
use src\requests\testRequest;
use src\support\Redirect;
use src\support\View;

class ExampleController extends Controller
{

    function __construct() {}

    public function index()
    {
        return View::render('form');
    }

    public function view()
    {
        dd('hello');
    }


    public function profile(string $t)
    {
        dd('content: ' . $t);
    }

    public function manyParams(string $n, string $p)
    {
        dd($n, $p);
    }

    public function uuid(string $uuid)
    {
        dd($uuid);
    }
}
