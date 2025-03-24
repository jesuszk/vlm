<?php

namespace src\services\product;

use Exception;
use src\exceptions\product\ProductListPaginatedFailedException;
use src\exceptions\product\ProductStoreFailedException;
use src\repositories\ProductRepository;

class ProductListService
{
    function __construct(
        private ProductRepository $repo
    ) {}

    function paginated()
    {
        try {
            return $this->repo->select_paginated();
        } catch (Exception $e) {
            throw new ProductListPaginatedFailedException();
        }
    }
}
