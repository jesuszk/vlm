<?php

namespace src\requests;



class testRequest extends Request
{
    protected array $rules = [
        'name' => 'required'
    ];
}
