<?php

namespace src\services;

use Exception;
use src\exceptions\product\ProductCreateFailedException;
use src\exceptions\product\ProductGetAllFailedException;
use src\repositories\ProductRepository;

class ProductService
{
    public function __construct(private ProductRepository $ProductRepository) {}

    public function create(array $data)
    {
        try {
            $product = $this->ProductRepository->create($data);
            return $product;
        } catch (Exception $e) {
            throw new ProductCreateFailedException($data);
        }
    }

    public function getAll()
    {
        try {
            return $this->ProductRepository->getAll();
        } catch (Exception $e) {
            throw new ProductGetAllFailedException();
        }
    }
}
