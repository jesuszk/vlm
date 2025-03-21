<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>




<body>
    <form action="" method="post">
        <input type="text" name="name">
        <button type="submit">send</button>
    </form>
</body>


<ul>
    <li><a href="<?= route('rota.varios.parametros', ['number' => 12, 'param' => 'cool', 'novo' => 't']) ?>">vários parâmetros</a></li>
    <li><a href="<?= route('blog.post.view', ['slug' => 'meu-primeiro-post-813']) ?>">Blog: veja como...</a></li>
    <li><a href="<?= route('user.profile.view', ['id' => 12]) ?>">ver perfil</a></li>
</ul>

</html>