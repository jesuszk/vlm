<!doctype html>
<html lang="pt-BR">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $webTitle ?? 'Web Title Default' ?></title>
    <link rel="stylesheet" href="<?= path()->css("/global.css") ?>">
    <?= $this->insert('templates/styles', ['styles' => $styles ?? []]) ?>
</head>



<body class="<?= $_ENV['APP_COMPANY'] ?>">
    <div class="container mt-4">
        <ul class="notificationsToasts"></ul>
        <div class="card mb-4">
            <div class="card-header">
                <div class="name-and-logo">
                    <span class="d-flex align-items-center"><?= $cardTitle ?? null ?></span>
                    <img src="<?= path()->images('/' . 'vellum' . '.png'); ?>" alt="Logo Empresa">
                </div>
            </div>
            <div class="card-body">
                <?= $this->section("content"); ?>
            </div>
        </div>
    </div>
    <script src="<?= path()->js("/bs5.js") ?>"></script>
    <script src="<?= path()->js("/init.js"); ?>"></script>
    <script src="<?= path()->js("/notification.js"); ?>"></script>
    <?= $this->insert('templates/js', ['js' => $js ?? []]) ?>
    <?php
    enableNotifications();
    forgetSessions(['old', 'zarkify', 'isWrong']);
    ?>
</body>

</html>