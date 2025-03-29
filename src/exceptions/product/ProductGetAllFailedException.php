<?php

namespace src\exceptions\product;

use Exception;
use src\traits\LogException;

class ProductGetAllFailedException extends Exception
{
    private string $entity = 'products';

    use LogException;

    function __construct(array $content = [])
    {
        $message = 'Não foi possível listar os produtos';
        $code = 500;
        $this->log($message, $code, json_encode($content));
        return parent::__construct($message, $code);
    }
}
