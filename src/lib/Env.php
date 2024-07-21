<?php

namespace MXJosueDev\TalleresCecyte\lib;

use Dotenv\Dotenv;

class Env
{
    private static function load()
    {
        $env = Dotenv::createImmutable(__DIR__ . "/../../");
        $env->load();
    }

    public static function getenv(string $name): ?string
    {
        if (getenv("LOADENV") === false) {
            self::load();

            return isset($_ENV[$name]) ? $_ENV[$name] : null;
        }

        $val = getenv($name);
        return $val !== false ? $val : null;
    }
}
