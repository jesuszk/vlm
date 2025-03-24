<?php

namespace src\requests\product;

use src\requests\Request;

class StoreRequest extends Request
{
    protected array $rules = [
        'name' => 'required',
        'price' => 'required',
        'amount' => 'required',
        'control_stock' => 'required',
    ];
}
