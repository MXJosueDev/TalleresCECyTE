<?php

$navOptions = ["inicio", "talleres", "comentarios", "ayuda"];

$navTitles = [
    "inicio" => "Inicio",
    "talleres" => "Talleres",
    "comentarios" => "Comentarios",
    "ayuda" => "Ayuda",
];

$navLinks = [
    "inicio" => "/",
    "talleres" => "/talleres",
    "comentarios" => "/comentarios",
    "ayuda" => "/ayuda",
];

?>

<nav class="navbar navbar-expand-md bg-body-tertiary">
    <div class="container-fluid">
        <!-- <a class="navbar-brand" href="#">Menu</a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header text-bg-primary">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex justify-content-between flex-column">
                <div class="d-flex align-items-start container-lg">
                    <ul class="navbar-nav justify-content-between flex-grow-1 gap-md-3 gap-lg-5 mx-3 text-center">
                        <?php foreach ($navOptions as $option) { ?>
                            <li class="nav-item">
                                <a class="nav-link fs-5<?php echo $view === $option ? " active" : "" ?>" href="<?php echo $view === $option ? "#" : $navLinks[$option] ?>"><?php echo $navTitles[$option]; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div id="social" class="d-flex justify-content-around d-md-none">
                    <div id="tiktok" class="socialIcon"><a href="https://www.tiktok.com/@cecyte_plantel_coroneo?_t=8mBZ4k6cW6X&amp;_r=1"><i class="fa-brands fa-tiktok"></i></a></div>
                    <div id="facebook" class="socialIcon"><a href="https://www.facebook.com/CecytegCoroneo?mibextid=ZbWKwL"><i class="fa-brands fa-facebook"></i></a></div>
                </div>
            </div>
        </div>
    </div>
</nav>