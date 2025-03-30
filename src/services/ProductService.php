<?php

namespace src\services;

use Exception;
use src\exceptions\product\ProductCreateFailedException;
use src\exceptions\product\ProductDeleteFailedException;
use src\exceptions\product\ProductGetAllFailedException;
use src\repositories\ProductRepository;

class ProductService
{
    public function __construct(private ProductRepository $ProductRepository) {}

    public function create(array $data)
    {
        try {
            $data['value_min'] = $data['value_min'] ?? 0;
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

    public function delete(string $uuid)
    {
        $deleted = $this->ProductRepository->deleteByUuid($uuid);
        if (!$deleted) 
            throw new ProductDeleteFailedException(['uuid' => $uuid]);
    }
}
