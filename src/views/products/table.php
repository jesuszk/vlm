<table class="table-responsive my-3">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Control Stock</th>
            <th>Value Min</th>
            <th>Above Min</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?= $product->name; ?></td>
                <td><?= $product->price; ?></td>
                <td><?= $product->quantity; ?></td>
                <td><?= $product->control_stock; ?></td>
                <td><?= $product->value_min; ?></td>
                <td><?= $product->quantity > $product->value_min ? "<span class='text-success'>Yes</span>" : "<span class='badge bg-danger'>No</span>"; ?></td>
                <td>
                    <a href="<?= route('products.edit', ['uuid' => $product->uuid]); ?>" class="btn btn-primary">Edit</a>
                    <a href="<?= route('products.delete', ['uuid' => $product->uuid]); ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>