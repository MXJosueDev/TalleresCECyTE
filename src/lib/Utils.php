<?php

namespace MXJosueDev\TalleresCecyte\lib;

class Utils
{
    public static function getPart(array &$full, $length): string
    {
        $result = array_splice($full, 0, $length);

        return implode($result);
    }
}
