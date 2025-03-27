<?php

namespace src\exceptions\product;

use Exception;
use src\traits\LogException;

class ProductUpdateFailedException extends Exception
{
    private string $entity = 'product';

    use LogException;

    function __construct(array $content)
    {
        $message = 'Não foi possível atualizar os dados do produto';
        $code = 500;
        $this->log($message, $code, json_encode($content));
        return parent::__construct($message, $code);
    }
} 