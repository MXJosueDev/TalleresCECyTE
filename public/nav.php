<?php

// error_reporting(0);

$workshopViews = [
    "inicio" => "inicio.php",
    "talleres" => "talleres.php",
    "comentarios" => "comentarios.php",
    "ayuda" => "ayuda.php",
];

$view = $_GET["nav"] ?? "inicio";

?>

<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talleres CECyTE</title>
    <script src="/assets/bundle.js"></script>

    <style>
        /* BRANDS: */

        .socialIcon {
            width: 75px;
            height: 75px;

            text-align: center;
            line-height: 75px;

            border-radius: 50%;
        }

        .socialIcon i {
            font-size: 20px;
        }

        #facebook:hover {
            padding: blue !important;
            box-shadow: 0 0 15px blue;
            transition: all 0.5s ease;
        }

        #facebook {
            transition: all 0.5s ease;
        }

        #facebook i {
            color: blue !important;
            text-shadow: 0 0 15px blue;
        }

        #tiktok:hover {
            padding: black !important;
            box-shadow: 0 0 15px black;
            transition: all 0.5s ease;
        }

        #tiktok {
            transition: all 0.5s ease;
        }

        #tiktok i {
            color: black !important;
            text-shadow: 0 0 15px black;
        }

        /* Aside */
        @keyframes Rotar {
            0% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(180deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #asideLogo {
            animation: Rotar 6s infinite;
            animation-timing-function: linear;
        }
    </style>
</head>

<body>
    <div id="root">
        <?php
        require "../src/components/HeadTitle.php";
        require "../src/components/Navbar.php";

        $errorView = __DIR__ . '/../src/views/error.php';

        $view = match (true) {
            isset($workshopViews[$view]) => __DIR__ . '/../src/views/' . $workshopViews[$view],
            true => $errorView
        };
        ?>
        <div class="min-vh-100">
            <?php try {
                require $view;
            } catch (Error $error) {
                require $errorView;
            } ?>
        </div>
        <?php

        require "../src/components/Footer.php";
        ?>
    </div>
</body>

</html>