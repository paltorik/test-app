<?php

namespace App\Service\QuestionerValidate\Picker;

class StringPicker extends BasePicker   implements IPicker
{
    public static function make(array $picker): IPicker
    {
        return new self($picker);
    }

    public function isValid(): bool
    {
        return $this->picker['value']??null && is_string($this->picker['value']);
    }
}
