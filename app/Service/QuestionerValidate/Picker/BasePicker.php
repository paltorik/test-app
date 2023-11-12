<?php

namespace App\Service\QuestionerValidate\Picker;

use function Symfony\Component\Translation\t;

abstract class BasePicker
{

    public function __construct(
        protected array $picker
    )
    {

    }
    public static function suitableThis(array $picker): bool
    {

        $type = $picker['type']??null;
        return ($type && $type===static::getType());
    }

    public static function getType(): string
    {
        return  'string';
    }
    public function isValid(): bool
    {
        return true;
    }

    public function getFields ():array
    {
        return [
          'value',
          'title',
          'type'
        ];
    }
    public function isValidStruct(): bool
    {
        foreach ($this->getFields() as $value) {
            if (empty($this->picker[$value])) return false;
        }
        return true;
    }
}
