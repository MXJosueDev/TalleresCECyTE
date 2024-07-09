<?php
$administrative = [
    "Rafael Jimenez Servin" => [
        "tel" => "421-103-37-91",
        "job" => "Encargado de orden",
    ],
    "Janet Isabel Nieves Parra" => [
        "tel" => "442-504-27-87",
        "job" => "Area de vinculacion"
    ],
    "Elvia Daniela Hernandez" => [
        "tel" => "421-105-82-37",
        "job" => "Area de docentes"
    ]
];
?>

<div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-3">
    <?php foreach ($administrative as $name => $data) { ?>
        <div class="col">
            <div class="card shadow overflow-hidden h-100">
                <div class="text-bg-primary card-body">
                    <h5 class="card-title"><?php echo $name ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $data["job"] ?></h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="fa-solid fa-phone"></i> <b>Telefono:</b> <?php echo isset($data['tel']) ? "<a href=\"tel:{$data['tel']}\">{$data['tel']}</a>" : "Sin datos." ?> <br />
                    </li>
                    <li class="list-group-item">
                        <i class="fa-solid fa-envelope"></i> <b>Correo:</b> <?php echo isset($data['mail']) ? "<a href=\"mailto:{$data['mail']}\">{$data['mail']}</a>" : "Sin datos." ?>
                    </li>
                </ul>
            </div>
        </div>
    <?php } ?>
</div>