<?php

namespace App\Service\QuestionerValidate;

use App\Models\Questioner;
use App\Service\QuestionerValidate\Picker\BooleanPicker;
use App\Service\QuestionerValidate\Picker\IPicker;
use App\Service\QuestionerValidate\Picker\StringPicker;
use Exception;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class QuestionerValidateService
{

    protected array $pickersFactory = [
        BooleanPicker::class,
        StringPicker::class
    ];

    protected ?Collection $schema = null;

    /**
     * @throws Exception
     */
    public function setFormRequest(string $formRequest): QuestionerValidateService
    {
        try {
            $this->schema = collect(json_decode($formRequest, true));
        } catch (\Exception $exception) {
            throw  static::getException($exception);
        }
        if ($this->schema === null && json_last_error() !== JSON_ERROR_NONE) {
            throw static::getException();
        }
        return $this;
    }

    public function validationByOriginal(Questioner $questioner): bool
    {
        $status=true;
        $original = collect(json_decode($questioner->schema, true));
        $original->each(function (array $item, $key) use(&$status){
           if (empty($this->schema[$key])){
               return $status = false;
           }
        });
        return $status;
    }


    private function eachSchema(callable $callable)
    {
        $status = true;
        try {
            $this->schema->each(function (array $pickerArray) use (&$status, $callable) {
                if ($pickersFactory = $this->obtainPicker($pickerArray)) {
                    return $status = $callable($pickersFactory);
                }
            });

        } catch (\Exception $exception) {
            throw  static::getException($exception);
        }
        return $status;
    }

    public function isValid(): bool
    {
        return $this->eachSchema(fn(IPicker $picker) => $picker->isValid() && $picker->isValidStruct());
    }

    public function isValidStructure(): bool
    {
        return $this->eachSchema(fn(IPicker $picker) => $picker->isValid());
    }


    public static function getException(\Exception $prevision = null): Exception
    {
        return new BadRequestException('Error parse and validation schema', 400, $prevision);
    }

    private function obtainPicker(array $pickerArray): ?IPicker
    {

        /** @var IPicker $picker */
        foreach ($this->pickersFactory as $picker) {
            if ($picker::suitableThis($pickerArray)) return $picker::make($pickerArray);
        }
        return null;
    }
}
