<?php $this->layout('templates/base', [
    'webTitle' => 'Zarkium Store - Products',
    'cardTitle' => 'Products',
    'styles' => [css_directory('/table-responsive.css')],
    'linkBack' => route('products.index')
]) ?>



<form class="row g-3 align-items-center" method="post" action="<?= route('products.store'); ?>">

    <div class="col-sm-12 col-md-4">
        <label class="fw-bold" for="name">Name <span>*</span></label>
        <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Product Name">
    </div>

    <div class="col-sm-12 col-md-3">
        <label class="fw-bold" for="price">Price <span>*</span></label>
        <input type="number" step="0.01" class="form-control form-control-sm" id="price" name="price" value="0">
    </div>

    <div class="col-sm-12 col-md-3">
        <label class="fw-bold" for="amount">Amount <span>*</span></label>
        <input type="number" step="0.01" class="form-control form-control-sm" id="amount" name="amount" value="0">
    </div>

    <div class="col-sm-12 col-md-2">
        <label class="fw-bold" for="controlStock">Control Stock <span>*</span></label>
        <select name="control_stock" id="controlStock" class="form-select form-select-sm">
            <option value="">Choose</option>
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
    </div>

    <div class="col-sm-12 col-md-12">
        <button type="submit" class="btn btn-company">Add <i class="ph ph-paper-plane-tilt"></i></button>
    </div>
</form>