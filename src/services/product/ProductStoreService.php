<?php

namespace src\services\product;

use Exception;
use src\exceptions\product\ProductStoreFailedException;
use src\repositories\ProductRepository;

class ProductStoreService
{
    function __construct(
        private ProductRepository $repo
    ) {}

    function store(array $data)
    {
        try {
            return $this->repo->store($data);
        } catch (Exception $e) {
            throw new ProductStoreFailedException($data);
        }
    }
}
