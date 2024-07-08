<?php

use MXJosueDev\TalleresCecyte\lib\Auth;

error_reporting(0);

require_once __DIR__ . '/../vendor/autoload.php';

$auth = new Auth();

?>

<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
    <script src="/assets/bundle.js"></script>
    <script src="/assets/lib/jquery.min.js"></script>
</head>

<body>
    <div id="root">
        <?php
        require "../src/components/HeadTitle.php";

        $errorView = __DIR__ . '/../src/views/error.php';
        ?>

        <div class="min-vh-100">
            <?php try {
                if ($auth->isAuth()) {
                    require __DIR__ . "/../src/views/listaComentarios.php";
                } else {
                    $auth->renderForm();
                }
            } catch (Exception $error) {
                require $errorView;
            } ?>
        </div>
        <?php

        require "../src/components/Footer.php";
        ?>
    </div>
</body>

</html>