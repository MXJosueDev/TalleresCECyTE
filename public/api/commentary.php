<?php

// error_reporting(0);

require_once '../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\utils\ClientUtils;
use MXJosueDev\TalleresCecyte\lib\db\DB;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBException;

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

    try {
        DB::registerCommentary($commentary, $ip);
    } catch (DBException $dBException) {
        echo json_encode([
            "error" => "DBError: " . $dBException->getMessage()
        ]);
        http_response_code(500);

        exit();
    }
} else {
    echo json_encode([
        "error" => "No se enviaron todos los parametros."
    ]);
    http_response_code(400);
}
