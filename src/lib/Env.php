<?php

namespace MXJosueDev\TalleresCecyte\lib;

use Dotenv\Dotenv;

class Env
{
    public static function load()
    {
        $env = Dotenv::createImmutable(__DIR__ . "/../../");
        $env->load();
    }
}
