<?php $this->layout('templates/base', [
    'webTitle' => 'Zarkium Store - Products',
    'cardTitle' => 'Products - Edit',
    'linkBack' => route('products.index')
]) ?>

<form action="<?= route('products.update', ['id' => $product['id']]) ?>" method="post">
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <label class="fw-bold" for="name">Name <span>*</span></label>
            <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Product Name" value="<?= $product['name'] ?>">
        </div>

        <div class="col-sm-12 col-md-3">
            <label class="fw-bold" for="price">Price <span>*</span></label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="price" name="price" value="<?= $product['price'] ?>">
        </div>

        <div class="col-sm-12 col-md-3">
            <label class="fw-bold" for="amount">Amount <span>*</span></label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="amount" name="amount" value="<?= $product['amount'] ?>">
        </div>

        <div class="col-sm-12 col-md-2">
            <label class="fw-bold" for="controlStock">Control Stock <span>*</span></label>
            <select name="control_stock" id="controlStock" class="form-select form-select-sm">
                <option value="">Choose</option>
                <option value="1" <?= $product['control_stock'] == 1 ? 'selected' : '' ?>>Sim</option>
                <option value="0" <?= $product['control_stock'] == 0 ? 'selected' : '' ?>>Não</option>
            </select>
        </div>

        <div class="col-sm-12 col-md-12 mt-3">
            <button type="submit" class="btn btn-company">Update <i class="ph ph-paper-plane-tilt"></i></button>
        </div>
    </div>
</form>