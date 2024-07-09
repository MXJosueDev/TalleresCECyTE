<?php

// error_reporting(0);

require_once __DIR__ . '/../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\auth\Auth;

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
        require __DIR__ . "/../../src/components/shared/HeadTitle.php";

        $errorView = __DIR__ . '/../../src/views/Error.php';
        ?>

        <div class="min-vh-100">
            <?php try {
                if ($auth->isAuth()) {
                    require __DIR__ . "/../../src/views/admin/CommentariesList.php";
                } else {
                    $auth->renderForm();
                }
            } catch (Exception $error) {
                require $errorView;
            } ?>
        </div>
        <?php

        require __DIR__ . "/../../src/components/shared/Footer.php";
        ?>
    </div>
</body>

</html>