<?php

use MXJosueDev\TalleresCecyte\lib\db\exception\DBExecuteException;

error_reporting(0);

require_once '../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\lib\db\DB;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBException;
use MXJosueDev\TalleresCecyte\utils\Utils;

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

    // Name & Last name FIXME:
    // $nameRegex = "/$[a-zA-Z+]^/";
    // if (!preg_match($nameRegex, $name) || !preg_match($nameRegex, $lastName)) {
    //     http_response_code(400);
    //     echo json_encode([
    //         "error" => "El nombre y apellidos solo deben contener letras."
    //     ]);
    //     exit();
    // }

    // Sex
    if (!in_array($sex, ["male", "female"])) {
        http_response_code(400);
        echo json_encode([
            "error" => "El sexo es invalido."
        ]);
        exit();
    }

    // Semester
    if (!in_array($semester, ["1", "2", "3", "4", "5", "6"])) {
        http_response_code(400);
        echo json_encode([
            "error" => "El semestre es invalido."
        ]);
        exit();
    }

    // Group
    if (!in_array($group, ["a", "b", "c"])) {
        http_response_code(400);
        echo json_encode([
            "error" => "El grupo es invalido."
        ]);
        exit();
    }

    // Get actual data
    try {
        $workshopData = DB::getWorkshop($workshopId);
    } catch (DBException $dBException) {
        http_response_code(500);
        echo json_encode([
            "error" => "DBError: " . $dBException->getMessage()
        ]);

        exit();
    }

    if ($workshopData["max_capacity"] - $workshopData["registered"] <= 0) {
        http_response_code(500);
        echo json_encode([
            "error" => "¡El taller ya esta lleno!"
        ]);
        exit();
    }

    // Insert: 
    try {
        DB::registerRecord((int) $workshopId, $controlNumber, $name, $lastName, $sex, (int) $careerId, $semester, $group);
    } catch (DBException $dBException) {
        if ($dBException instanceof DBExecuteException) {
            http_response_code(500);
            echo json_encode([
                "error" => "No se pudo guardar el registro (Probablemente el numero de control ya fue registrado)"
            ]);

            exit();
        }

        echo json_encode([
            "error" => "DBError: " + $dBException->getMessage()
        ]);

        exit();
    }
} else {
    http_response_code(400);
    echo json_encode([
        "error" => "No se enviaron todos los parametros."
    ]);
}
