<?php

namespace App\Enum;


enum GenderEnum :string
{
    use BaseEnum;

    case FEMALE = 'female';
    case MALE = 'male';

    public function translate(): string
    {
        return match ($this) {
            self::FEMALE => 'женский',
            self::MALE => 'мужской'
        };
    }
}
