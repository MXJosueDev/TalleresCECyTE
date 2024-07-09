<?php

error_reporting(0);

require_once __DIR__ . '/../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\lib\db\DB;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBException;

$workshopViews = [
    "registro" => "WorkshopRegister.php",
    "lista" => "WorkshopStudentList.php",
];

if (!isset($_GET["workshop"]) || !isset($_GET["view"])) {
    echo "Por favor ingresa todos los parametros.";
    http_response_code(400);

    return;
}

$workshopId = (int) $_GET["workshop"];
$view = $_GET["view"];


try {
    $workshopData = DB::getWorkshop($workshopId);
} catch (DBException $dBException) {
    DB::renderException($dBException);
    exit();
}

?>

<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller</title>
    <script src="/assets/bundle.js"></script>
    <script src="/assets/lib/jquery.min.js"></script>
</head>

<body>
    <div id="root">
        <?php
        require __DIR__ . "/../../src/components/shared/HeadTitle.php";

        $errorView = __DIR__ . '/../../src/views/Error.php';

        $view = match (true) {
            isset($workshopViews[$view]) => __DIR__ . '/../../src/views/workshop/' . $workshopViews[$view],
            true => $errorView
        };
        ?>

        <div class="min-vh-100">
            <?php try {
                require $view;
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