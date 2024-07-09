<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\lib\db\DB;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBException;

try {
    $records = DB::getAllRecords($workshopId);
} catch (DBException $dBException) {
    DB::renderException($dBException);
    exit();
}

?>

<div class="bg-body-tertiary py-3 px-4">
    <a href="/taller/registro/<?php echo $workshopId ?>" class="fs-5">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>

<div class="container py-3">
    <div>
        <h4 class="display-5 fw-bold"><?php echo $workshopData['workshop_name'] ?></h4>
        <p><i class="fa-solid fa-person-chalkboard"></i> <b>Instructor:</b> <?php echo $workshopData['teacher_name'] . ' ' . $workshopData['last_name'] ?></p>
        <p><i class="fa-solid fa-people-group"></i> <b>Capacidad:</b> <?php echo $workshopData['max_capacity'] ?> Espacios (<?php echo $workshopData['max_capacity'] - $workshopData['registered'] ?> restantes)</p>
    </div>

    <div class="p-1 mt-3">
        <?php if ($workshopData['registered'] > 0) { ?>

            <div class="table-responsive-md">
                <table class="table table-sm table-striped table-hover" style="min-width: 700px;">
                    <thead>
                        <tr>
                            <th>Numero de control</th>
                            <th>Apellidos</th>
                            <th>Nombre</th>
                            <th>Sexo</th>
                            <th>Grupo</th>
                            <th>Fecha de registro</th>
                        </tr>
                    </thead>

                    <tbody class="text-uppercase">
                        <?php foreach ($records as $record) { ?>
                            <tr>
                                <td><?php echo $record['control_number'] ?></td>
                                <td><?php echo $record['last_name'] ?></td>
                                <td><?php echo $record['student_name'] ?></td>
                                <td><?php echo $record['sex'] === "male" ? "hombre" : "mujer" ?></td>
                                <td><?php echo $record['semester'] . ' ' . $record['short_name'] . ' ' . $record['group'] ?></td>
                                <td><?php echo $record['register_date'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <h4 class="text-center">No hay ningun registro.</h4>
        <?php } ?>

    </div>

    <div class="d-flex justify-content-end">
        <a class="btn btn-success" href="/taller/print/<?php echo $workshopId ?>" target="_blank">Generar lista de asistencia</a>
    </div>
</div>