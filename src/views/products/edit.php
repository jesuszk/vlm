<?= $this->layout('templates/base', [
    'title' => 'Products Edit',
    'cardTitle' => 'Products Edit',
    'styles' => [
        path()->css('/table-responsive.css'),
    ]
]) ?>


<form action="<?= route('products.update', ['uuid' => $product->uuid]); ?>" method="post">
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <label for="name" class="form-label fw-bold">Name <span class="">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Name" value="<?= $product->name; ?>">
        </div>

        <div class="col-12 col-md-2">
            <label for="price" class="form-label fw-bold">Price <span class="">*</span></label>
            <input type="number" step="0.01" class="form-control" name="price" placeholder="Price" value="<?= $product->price; ?>">
        </div>

        <div class="col-12 col-md-2">
            <label for="quantity" class="form-label fw-bold">Quantity <span class="">*</span></label>
            <input type="number" class="form-control" name="quantity" placeholder="Quantity" value="<?= $product->quantity; ?>">
        </div>

        <div class="col-12 col-md-2">
            <label for="control_stock" class="form-label fw-bold">Control Stock <span class="">*</span></label>
            <select name="control_stock" id="control_stock" class="form-select" onchange="toggleValueMin()">
                <option value="1" <?= isSelect($product->control_stock, 1); ?>>Yes</option>
                <option value="0" <?= isSelect($product->control_stock, 0); ?>>No</option>
            </select>
        </div>

        <div id="value-min" class="col-12 col-md-2">
            <label for="value_min" class="form-label fw-bold">Value Min <span class="">*</span></label>
            <input type="number" class="form-control" name="value_min" placeholder="Value Min" value="<?= $product->value_min; ?>">
        </div>

        <div class="col-12">
            <button class="btn btn-company float-end">Update <i class="ph ph-paper-plane-tilt"></i></button>
        </div>
    </div>
</form>