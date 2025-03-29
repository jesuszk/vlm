<?php

namespace src\controllers;

use Exception;
use RedirectHeader;
use src\requests\products\ProductStoreRequest;
use src\services\ProductService;
use src\support\View;

class ProductController
{
    public function __construct(private ProductService $ProductService) {}

    public function index()
    {
        try {
            $products = $this->ProductService->getAll();
            return View::render('products.index', ['products' => $products]);
        } catch (Exception $e) {
            notification()->error($e->getMessage());
            return View::render('products.index', ['products' => []]);
        }
    }

    public function store(ProductStoreRequest $request): RedirectHeader
    {
        try {
            $this->ProductService->create($request->get());
            notification()->success('Product created successfully');
            return redirect()->route('products.index');
        } catch (Exception $e) {
            notification()->error($e->getMessage());
            return redirect()->route('products.index');
        }
    }
}
