<?php

error_reporting(0);

require_once '../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\utils\ClientUtils;
use MXJosueDev\TalleresCecyte\lib\DB;

if (isset($_POST["commentary"])) {
    $commentary = $_POST["commentary"];
    $ip = ClientUtils::getClientIP();

    if (mb_strlen($commentary) > 4096) {
        http_response_code(500);
        echo json_encode([
            "error" => "El comentario no puede tener mas de 4096 caracteres."
        ]);
        exit();
    }

    $db = new DB();
    $conn = $db->getConnection();
    if (!$conn) {
        http_response_code(500);
        echo json_encode([
            "error" => "No se pudo conectar a la base de datos."
        ]);
        exit();
    }

    $workshopStmt = $conn->prepare(DB::QUERIES["register_commentary"]);

    if ($workshopStmt) {
        $workshopStmt->bind_param('ss', $commentary, $ip);

        try {
            if (!$workshopStmt->execute()) {
                echo http_response_code(500);
                echo json_encode([
                    "error" => "No se pudo guardar el comentario."
                ]);
                exit();
            }
        } catch (Exception $exception) {
            http_response_code(500);
            echo json_encode([
                "error" => "No se pudo guardar el comentario."
            ]);
            exit();
        }
    }

    exit();
}

echo json_encode([
    "error" => "No se enviaron todos los parametros."
]);
http_response_code(400);
