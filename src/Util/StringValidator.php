<?php

namespace App\Util;

class StringValidator
{
    public static function isValidBusinessId(string $id): bool
    {
        return preg_match("/[0-9]{7}\\-[0-9]{1}/", $id);
    }
}