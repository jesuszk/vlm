<?php $this->layout('templates/base', [
    'webTitle' => 'Zarkium Store - Products',
    'cardTitle' => 'Products',
    'styles' => [css_directory('/table-responsive.css')]
]) ?>




<a href="" class="btn btn-sm btn-company float-end mb-3 d-flex align-items-center">New Product <i class="ph ph-plus ms-1"></i></a>

<table class="table-responsive">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Amount</th>
            <th>Control Stock?</th>
            <th>In Value</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (isset($products->raw) && $products->raw) { ?>
            <?php foreach ($products->paginated as $product) { ?>
                <tr>
                    <td><?= $product->id ?></td>
                    <td><?= $product->name ?></td>
                    <td><?= $product->price ?></td>
                    <td><?= $product->amount ?></td>
                    <td><?= $product->control_stock ?></td>
                    <td><?= $product->price * $product->amount ?></td>
                    <td>
                        <a href="<?= route('products.delete', ['uuid' => $product->uuid, 'name' => $product->name]) ?>" class="btn btn-danger btn-sm">Delete <i class="ph ph-trash"></i></a>
                        <a href="<?= route('products.edit', ['id' => $product->id]) ?>" class="btn btn-primary btn-sm">Edit <i class="ph ph-pencil"></i></a>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>