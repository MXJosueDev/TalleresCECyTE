<?php

error_reporting(0);

require_once __DIR__ . '/../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\lib\db\DB;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBException;

if (!isset($_GET["workshop"])) {
    echo "Por favor ingresa todos los parametros.";
    http_response_code(400);

    return;
}

$workshopId = $_GET["workshop"];

try {
    $workshopData = DB::getWorkshop($workshopId);
    if ($workshopData === null) {
        http_response_code(404);
        exit();
    }

    $records = DB::getAllRecords($workshopId);
} catch (DBException $dBException) {
    DB::renderException($dBException);
    exit();
}

ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista</title>

    <style>
        * {
            margin: 0;
            padding: 0;

            box-sizing: border-box;
        }

        #cecyte {
            width: 30px;
            height: auto;
        }

        #info {
            margin-top: 30px;
            margin-bottom: 20px;

            font-size: 10px;
            line-height: 18px;

            text-transform: uppercase;
        }

        h2 {
            text-align: center;

            font-size: 12px;
        }

        hr {
            color: inherit;
            border: 0;

            margin: 5px 0;

            border-top: 2px solid;

            opacity: 0.50;
        }

        body {
            padding: 40px;

            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border-bottom: 1px solid #000;

            text-align: left;
        }

        th {
            padding-left: 4px;

            padding-top: 12px;
            padding-bottom: 12px;

            font-size: 10px;
        }

        td {
            text-transform: uppercase;
            padding: 4px;

            font-size: 8px;
        }

        th.bordered {
            border-top: 0px;
        }

        .bordered {
            border: 1px solid #000;

            padding: 0;
            width: 2.2%;
        }

        .inline {
            display: inline-block;
        }
    </style>
</head>

<body>
    <!-- <img src="http://localhost/assets/image/logo.png" id="cecyte" alt="CECyTE Logo"> --> <!-- FIXME: Usa muchos recursos -->

    <h2>COLEGIO DE ESTUDIOS CIENTIFICOS Y TECNOLOGICOS DEL ESTADO DE GUANAJUATO</h2>
    <hr />
    <h2>LISTA DE ASISTENCIA</h2>

    <div id="info">
        <div class="inline">
            <p>TALLER:</p>
            <p>INSTRUCTOR:</p>
            <p>ALUMNOS:</p>
        </div>
        <div class="inline" style="margin-left: 20px;">
            <p><?php echo $workshopData['workshop_name'] ?></p>
            <p><?php echo $workshopData['teacher_name'] . ' ' . $workshopData['last_name'] ?></p>
            <p><?php echo $workshopData['registered'] . '/' . $workshopData['max_capacity'] ?></p>
        </div>
    </div>

    <?php if ($workshopData['registered'] > 0) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 12%;">N° Control</th>
                    <th style="width: 18%;">Apellidos</th>
                    <th style="width: 16%;">Nombre</th>
                    <th style="width: 10%;">Grupo</th>
                    <?php for ($i = 0; $i < 20; $i++) { ?>
                        <th class="bordered"></th>
                    <?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($records as $record) { ?>
                    <tr>
                        <td><?php echo $record['control_number'] ?></td>
                        <td><?php echo $record['last_name'] ?></td>
                        <td><?php echo $record['student_name'] ?></td>
                        <td><?php echo $record['semester'] . ' ' . $record['short_name'] . ' ' . $record['group'] ?></td>
                        <?php for ($i = 0; $i < 20; $i++) { ?>
                            <td class="bordered"></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <h2>No hay ningun registro.</h2>
    <?php } ?>
</body>

<?php

use Dompdf\Dompdf;

$html = ob_get_clean();

// echo $html;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(["isRemoteEnabled" => true]);
$dompdf->setOptions($options);

$dompdf->setPaper("A4");

$dompdf->loadHtml($html, "UTF-8");
$dompdf->render();

$dompdf->stream("Lista_Asistencia_" . str_replace(" ", "_", $workshopData["workshop_name"]) . ".pdf", [
    "Attachment" => false
]);
