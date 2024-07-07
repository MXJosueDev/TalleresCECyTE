<?php
error_reporting(0);

require_once '../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\lib\DB;
use MXJosueDev\TalleresCecyte\lib\Utils;

if (isset($_POST["workshop"]) && isset($_POST["control-number"]) && isset($_POST["name"]) && isset($_POST["last-name"]) && isset($_POST["sex"]) && isset($_POST["career"]) && isset($_POST["semester"]) && isset($_POST["group"])) {
    $workshopId = (int) $_POST["workshop"];
    $controlNumber = $_POST["control-number"];
    $name = $_POST["name"];
    $lastName = $_POST["last-name"];
    $sex = $_POST["sex"];
    $careerId = (int) $_POST["career"];
    $semester = $_POST["semester"];
    $group = $_POST["group"];

    // Validate
    if (!preg_match("/^[0-9]{14}$/", $controlNumber)) {
        http_response_code(400);
        echo json_encode([
            "error" => "El numero de control no tiene un formato valido."
        ]);
        exit();
    }

    $destructured_control = str_split($controlNumber);
    $currentYear = (int) date("y");
    $year = (int) Utils::getPart($destructured_control, 2);
    $generic = Utils::getPart($destructured_control, 6);
    $plantel = Utils::getPart($destructured_control, 2);
    $studentId = (int) Utils::getPart($destructured_control, 4);

    // Note: Change this in case of necesary
    if ($year < $currentYear - 3 || $year > $currentYear || $generic !== "411070" || $plantel !== "13" || $studentId < 0 || $studentId > 400) {
        http_response_code(400);
        echo json_encode([
            "error" => "El numero de control no existe."
        ]);
        exit();
    }

    // DB
    $db = new DB();
    $conn = $db->getConnection();
    if (!$conn) {
        http_response_code(500);
        echo json_encode([
            "error" => "No se pudo conectar a la base de datos."
        ]);
        exit();
    }

    // Get actual data
    $workshopDataStmt = $conn->prepare(DB::QUERIES["get_workshop_data"]);

    if ($workshopDataStmt) {
        $workshopDataStmt->bind_param('i', $workshopId);
        if ($workshopDataStmt->execute()) {
            $workshopResult = $workshopDataStmt->get_result();
            $workshopData = $workshopResult->fetch_assoc();

            $workshopResult->free();
        }
    }

    if ($workshopData["max_capacity"] - $workshopData["registered"] <= 0) {
        http_response_code(500);
        echo json_encode([
            "error" => "¡El taller ya esta lleno!"
        ]);
        exit();
    }

    // TODO: Verify control number

    // Insert
    $workshopRegisterStmt = $conn->prepare(DB::QUERIES["register_record"]);

    if ($workshopRegisterStmt) {
        $workshopRegisterStmt->bind_param('issssiss', $workshopId, $controlNumber, $name, $lastName, $sex, $careerId, $semester, $group);

        if (!$workshopRegisterStmt->execute()) {
            echo http_response_code(500);
            echo json_encode([
                "error" => "No se pudo guardar el registro en la base de datos."
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
