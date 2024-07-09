<?php

namespace MXJosueDev\TalleresCecyte\auth;

use MXJosueDev\TalleresCecyte\lib\Env;

class Auth
{
    public function isAuth(): bool
    {
        if (isset($_POST["auth_password"])) {
            Env::load();

            $password = $_POST["auth_password"];

            if ($password === $_ENV["ADMIN_PASSWORD"]) return true;
        }

        return false;
    }

    public function renderForm(): void
    {
        require __DIR__ . "/../views/auth/Auth.php";
    }
}
