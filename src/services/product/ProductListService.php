<?php

namespace src\services\product;

use Exception;
use src\exceptions\product\ProductFindFailedException;
use src\exceptions\product\ProductListPaginatedFailedException;
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
            throw new ProductListPaginatedFailedException(['message:' => $e->getMessage()]);
        }
    }

    function find(int $id)
    {
        try {
            return $this->repo->find($id);
        } catch (Exception $e) {
            throw new ProductFindFailedException(['id' => $id]);
        }
    }
}
