<?php

namespace src\controllers;

use Exception;
use RedirectHeader;
use src\exceptions\product\ProductStoreFailedException;
use src\requests\product\StoreRequest;
use src\services\product\ProductListService;
use src\services\product\ProductStoreService;
use src\support\View;

class ProductController
{
    function __construct(
        private ProductStoreService $productStoreService,
        private ProductListService $productListService,
    ) {}

    function index(): View
    {
        $products = null;
        try {
            $products = $this->productListService->paginated();
        } catch (Exception $e) {
            notification()->warning($e->getMessage());
        } finally {
            return View::render('products.index', ['products' => $products]);
        }
    }

    function create(): View
    {
        return View::render('products.create');
    }

    function store(StoreRequest $request): RedirectHeader
    {
        try {
            $productId = $this->productStoreService->store($request->get());
            notification()->success("O produto foi criado com sucesso e está disponível, id: {$productId}");
            return redirect()->route('products.index');
        } catch (ProductStoreFailedException $e) {
            notification()->error($e->getMessage());
            return redirect()->back();
        }
    }


    function varios(string $uuidv1, string $uuidv2)
    {
        dd($uuidv1, $uuidv2);
    }
}
