<?php if (isset($styles)) { ?>
    <?php foreach ($styles as $index => $style) { ?>
        <link rel="stylesheet" href="<?= $style ?>">
    <?php } ?>
<?php } ?>