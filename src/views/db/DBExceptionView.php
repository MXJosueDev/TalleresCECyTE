<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>
    <script src="/assets/bundle.js"></script>
</head>

<body>
    <div id="root">
        <?php
        require __DIR__ . "/../../components/shared/HeadTitle.php";

        ?>
        <div class="container min-vh-100">
            <?php require __DIR__ . "/../../components/db/DBExceptionText.php"; ?>
        </div>
        <?php

        require __DIR__ . "/../../components/shared/Footer.php";
        ?>
    </div>
</body>

</html>