<?php

error_reporting(0);

require_once __DIR__ . '/../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\lib\DB;

$workshopViews = [
    "registro" => "WorkshopRegister.php",
    "lista" => "WorkshopStudentList.php",
];

if (!isset($_GET["workshop"]) || !isset($_GET["view"])) {
    echo "Por favor ingresa todos los parametros.";
    http_response_code(400);

    return;
}

$commentary = (int) $_GET["workshop"];
$view = $_GET["view"];

$db = new DB();
$conn = $db->getConnection();
if (!$conn) {
    echo "<h5 class=\"text-center mt-4\">Ocurrio un error al intentar conectarse con la base de datos</h5>";
    return;
}

$workshopStmt = $conn->prepare(DB::QUERIES["get_workshop_data"]);
if ($workshopStmt) {
    $workshopStmt->bind_param("i", $commentary);
    if ($workshopStmt->execute()) {
        $workshopResult = $workshopStmt->get_result();
        
        if ($workshopResult->num_rows === 0) {
            http_response_code(404);
            exit();
        }

        $workshopData = $workshopResult->fetch_assoc();

        $workshopResult->free();
    }
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