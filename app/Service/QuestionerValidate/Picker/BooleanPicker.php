<?php

namespace App\Service\QuestionerValidate\Picker;

class BooleanPicker extends BasePicker implements IPicker
{
    public static function make(array $picker): IPicker
    {
        return new self($picker);
    }

    public static function getType(): string
    {
        return 'boolean';
    }
    public function isValid(): bool
    {
        return $this->picker['value']??null && is_bool($this->picker['value']);
    }
}
