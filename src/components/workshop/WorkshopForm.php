<?php

require_once __DIR__ . "/../../../vendor/autoload.php";

use MXJosueDev\TalleresCecyte\lib\db\DB;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBException;

try {
    $carieers = DB::getCarieers();
} catch (DBException $dBException) {
    DB::renderException($dBException, true);
    return;
}

?>

<form id="workshopForm" class="shadow rounded bg-body-tertiary overflow-hidden">
    <div class="row g-0">
        <div class="col-12 col-md-6">
            <div class="ratio ratio-16x9">
                <img src="<?php echo $workshopData['image_url'] ?>" alt="" class="object-fit-cover">
            </div>
        </div>
        <div class="col-12 col-md-6 px-4 pt-2">
            <h4 class="display-5 fw-bold"><?php echo $workshopData['workshop_name'] ?></h4>
            <p><i class="fa-solid fa-person-chalkboard"></i> <b>Instructor:</b> <?php echo $workshopData['teacher_name'] . ' ' . $workshopData['last_name'] ?></p>
            <p><i class="fa-solid fa-people-group"></i> <b>Capacidad:</b> <?php echo $workshopData['max_capacity'] ?> Espacios (<?php echo $workshopData['max_capacity'] - $workshopData['registered'] ?> restantes)</p>
        </div>
    </div>

    <div class="p-4 pt-2 pb-4">
        <div class="row g-3">
            <div class="col-12">
                <label for="control-number" class="form-label">Numero de control:</label>
                <input type="text" class="form-control" placeholder="Ingresa tu numero de control" id="control-number" name="control-number" minlength="14" maxlength="14" pattern="[0-9]{14}" required></input>
            </div>
            <div class="col-12 col-md-6">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa tu nombre" maxlength="32" required></input>
            </div>
            <div class="col-12 col-md-6">
                <label for="last-name" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="last-name" name="last-name" placeholder="Ingresa tus apellidos" maxlength="64" required></input>
            </div>
            <div class="col-12 col-md-6">
                <label for="sex" class="form-label">Sexo:</label>
                <select class="form-select" id="sex" name="sex" required>
                    <option value="" selected>-- Selecciona --</option>
                    <option value="male">Hombre</option>
                    <option value="female">Mujer</option>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label for="career" class="form-label">Especialidad:</label>
                <select class="form-select" id="career" name="career" required>
                    <option value="" selected>-- Selecciona --</option>
                    <?php foreach ($carieers as $carieerData) { ?>
                        <option value="<?php echo $carieerData['career_id'] ?>"><?php echo $carieerData['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label for="semester" class="form-label">Semestre:</label>
                <select class="form-select" id="semester" name="semester" required>
                    <option value="" selected>-- Selecciona --</option>
                    <option value="1">Primer Semestre</option>
                    <option value="2">Segundo Semestre</option>
                    <option value="3">Tercer Semestre</option>
                    <option value="4">Cuarto Semestre</option>
                    <option value="5">Quinto Semestre</option>
                    <option value="6">Sexto Semestre</option>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label for="group" class="form-label">Grupo:</label>
                <select class="form-select" id="group" name="group" required>
                    <option value="" selected>-- Selecciona --</option>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                </select>
            </div>

            <div class="col-12 form-text">
                Por favor verifica que todos tus datos sean correctos antes de enviar el formulario (No se podran hacen cambios despues)
            </div>
        </div>

        <div class="row g-3 mt-4">
            <div class="col-12 col-md-6">
                <a class="btn btn-outline-primary w-100 p-3" href="/taller/lista/<?php echo $workshopId ?>">Ver registrados</a>
            </div>
            <div class="col-12 col-md-6">
                <input class="btn btn-primary w-100 p-3" type="submit" value="Registrarse">
            </div>
        </div>

        <div id="alert" class="alert mt-3 d-none" role="alert"></div>
    </div>
</form>

<script>
    const workshop = <?php echo $workshopId ?>;
    const full = <?php echo $workshopData['max_capacity'] - $workshopData['registered'] <= 0 ? "true" : "false" ?>;

    $(() => {
        const workshopForm = $("#workshopForm");
        const button = $("#workshopForm input[type=\"submit\"");
        const alert = $("#workshopForm .alert");


        if (!full) {
            workshopForm.submit((event) => {
                event.preventDefault();

                button.addClass("disabled");
                button.attr("value", "Enviando...");

                $("#workshopForm input[type=\"text\"]").each((index, input) => {
                    input.value = input.value.trim().replace(/\s+/g, ' ');
                });

                const formData = workshopForm.serialize() + "&workshop=" + workshop;
                $('#workshopForm input, #workshopForm select').attr('readonly', 'readonly').attr('disabled', 'disabled');

                $.post({
                        url: "/api/workshop.php",
                        data: formData
                    })
                    .done(() => {
                        alert.removeClass("alert-danger");

                        alert.removeClass("d-none");
                        alert.addClass("alert-success");
                        alert.text("¡Te has registrado con exito!");

                        button.removeClass("btn-primary");
                        button.addClass("btn-success");

                        setTimeout(() => {
                            location.reload();
                        }, 3 * 1000);
                    })
                    .catch((res) => {
                        const data = JSON.parse(res.responseText);

                        alert.removeClass("d-none");
                        alert.addClass("alert-danger");
                        alert.text("Ocurrio un error al intentar registrarte: " + data.error);
                        
                        $('#workshopForm input, #workshopForm select').removeAttr('readonly').removeAttr('disabled');
                        button.removeClass("disabled");
                        
                        setTimeout(() => {
                            alert.addClass("d-none");
                            alert.removeClass("alert-danger");
                        }, 6 * 1000);
                    })
                    .always(() => {
                        button.attr("value", "Registrarse");

                        location.hash = "";
                        location.hash = "#alert";
                    });
            });
        } else {
            $('#workshopForm input, #workshopForm select').attr('readonly', 'readonly').attr('disabled', 'disabled');
            button.attr("value", "El taller ya esta lleno");

            button.removeClass("btn-primary");
            button.addClass("btn-danger");
        }
    });
</script>