<?php

namespace src\exceptions\product;

use Exception;
use src\traits\LogException;

class ProductDeleteFailedException extends Exception
{
    private string $entity = 'product';

    use LogException;

    function __construct(string $uuid)
    {
        $message = 'Não foi possível excluir o produto';
        $code = 500;
        $this->log($message, $code, json_encode(['uuid' => $uuid]));
        return parent::__construct($message, $code);
    }
}
