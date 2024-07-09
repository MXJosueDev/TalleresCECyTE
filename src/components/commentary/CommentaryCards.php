<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use MXJosueDev\TalleresCecyte\lib\db\DB;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBException;

try {
    $commentaries = DB::getAllCommentaries();
} catch (DBException $dBException) {
    DB::renderException($dBException);
    exit();
}

?>

<?php if (count($commentaries) === 0) { ?>
    <h4 class="text-center">No hay ningun comentario.</h4>
<?php } else { ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
        <?php foreach ($commentaries as $commentary) { ?>
            <div class="col">
                <div class="card shadow w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-center">#<?php echo $commentary['commentary_id'] ?></h5>
                        <h6 class="card-subtitle"><b>IP del cliente:</b> <?php echo $commentary['client_ip'] ?></h6>
                        <h6 class="card-subtitle mt-1"><b>Fecha:</b> <?php echo $commentary['register_date'] ?></h6>
                        <div class="mt-4">
                            <textarea rows="7" class="form-control" maxlength="4096" readonly style="resize: none;"><?php echo $commentary['commentary'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>