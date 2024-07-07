<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\lib\DB;

$db = new DB();
$conn = $db->getConnection();
if (!$conn) {
    echo "<h5 class=\"text-center\">Ocurrio un error al intentar conectarse con la base de datos</h5>";
    return;
}

$workshopStmt = $conn->prepare(DB::QUERIES["get_all_workshops_data"]);

if ($workshopStmt) {
    if ($workshopStmt->execute()) {
        $workshopResult = $workshopStmt->get_result();
    }
}

?>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
    <?php
    while (($workshop = $workshopResult->fetch_assoc()) !== null) { ?>
        <div class="col">
            <div class="card shadow w-100 h-100">
                <div class="ratio ratio-16x9">
                    <img src="<?php echo $workshop['image_url'] ?>" class="card-img-top object-fit-cover" alt="Imagen de <?php echo $workshop['workshop_name'] ?>">
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold"><?php echo $workshop['workshop_name'] ?></h5>
                    <h6 class="card-subtitle"><?php echo $workshop['teacher_name'] . ' ' . $workshop['last_name'] ?></h6>
                    <div class="d-flex mt-2" style="margin-block-end: 1em;">
                        <p class="card-text m-0"><small class="text-body-secondary"><?php echo $workshop['max_capacity'] ?> Espacios (<?php echo $workshop['max_capacity'] - $workshop['registered'] ?> restantes)</small></p>
                        <?php if ($workshop['max_capacity'] - $workshop['registered'] <= 0) { ?>
                            <div class="ms-1">
                                <p class="badge bg-danger m-0">Lleno</p>
                            </div>
                        <?php } ?>
                    </div>
                    <a href="/taller/registro/<?php echo $workshop['workshop_id'] ?>" class="btn btn-primary">Registrarse</a>
                </div>
            </div>

        </div>
    <?php
    }

    $workshopResult->free();
    ?>
</div>