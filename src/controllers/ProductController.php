<?php

namespace src\controllers;

use Exception;
use RedirectHeader;
use src\exceptions\product\ProductStoreFailedException;
use src\requests\product\StoreRequest;
use src\requests\product\UpdateRequest;
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

    function edit(int $id): View
    {
        $product = $this->productListService->find($id);
        return View::render('products.edit', ['product' => $product]);
    }

    function delete(string $uuid): RedirectHeader
    {
        try {
            $this->productStoreService->delete($uuid);
            notification()->success("O produto foi deletado com sucesso");
            return redirect()->route('products.index');
        } catch (Exception $e) {
            notification()->error($e->getMessage());
            return redirect()->back();
        }
    }

    function update(UpdateRequest $request, int $id): RedirectHeader
    {
        try {
            $this->productStoreService->update($request->get(), $id);
            notification()->success("O produto foi atualizado com sucesso");
            return redirect()->route('products.index');
        } catch (Exception $e) {
            notification()->error($e->getMessage());
            return redirect()->back();
        }
    }
}
