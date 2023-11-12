<?php

namespace App\Enum;

trait BaseEnum
{
    public static function toArray():array{
        return array_column(self::cases(),'value');
    }

    public static function byRules(): string
    {
        return "in:" . implode(',', self::toArray());
    }
}
