<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\lib\db\DB;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBException;

try {
    $workshops = DB::getAllWorkshops();
} catch (DBException $dBException) {
    DB::renderException($dBException, true);
    return;
}

?>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
    <?php
    foreach ($workshops as $workshopData) { ?>
        <div class="col">
            <div class="card shadow w-100 h-100">
                <div class="ratio ratio-16x9">
                    <img src="<?php echo $workshopData['image_url'] ?>" class="card-img-top object-fit-cover" alt="Imagen de <?php echo $workshopData['workshop_name'] ?>">
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold"><?php echo $workshopData['workshop_name'] ?></h5>
                    <h6 class="card-subtitle"><?php echo $workshopData['teacher_name'] . ' ' . $workshopData['last_name'] ?></h6>
                    <div class="d-flex mt-2" style="margin-block-end: 1em;">
                        <p class="card-text m-0 me-1"><small class="text-body-secondary"><?php echo $workshopData['max_capacity'] ?> Espacios (<?php echo $workshopData['max_capacity'] - $workshopData['registered'] ?> restantes)</small></p>
                        <?php if ($workshopData['max_capacity'] - $workshopData['registered'] <= 0) { ?>
                            <div>
                                <p class="badge bg-danger m-0">Lleno</p>
                            </div>
                        <?php } ?>
                    </div>
                    <a href="/taller/registro/<?php echo $workshopData['workshop_id'] ?>" class="btn btn-primary">Registrarse</a>
                </div>
            </div>

        </div>
    <?php
    }

    $workshopResult->free();
    ?>
</div>