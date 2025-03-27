<?php

namespace src\services\product;

use Exception;
use src\exceptions\product\ProductStoreFailedException;
use src\exceptions\product\ProductUpdateFailedException;
use src\exceptions\product\ProductDeleteFailedException;
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

    function update(array $data, int $id)
    {
        try {
            return $this->repo->update($data)->where('id', '=', $id)->finish();
        } catch (Exception $e) {
            throw new ProductUpdateFailedException($data);
        }
    }

    function delete(string $uuid)
    {
        try {
            return $this->repo->delete()->where('uuid', '=', $uuid)->finish();
        } catch (Exception $e) {
            throw new ProductDeleteFailedException($uuid);
        }
    }
}
