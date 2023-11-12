<?php

namespace App\Service\QuestionerValidate\Picker;

interface IPicker
{
    public function __construct(array $picker);

    public static function suitableThis(array $picker):bool;
    public static function make(array $picker): IPicker;

    public function isValid(): bool;

    public  static function getType():string;

    public function isValidStruct():bool;
    public function getFields ():array;

}
