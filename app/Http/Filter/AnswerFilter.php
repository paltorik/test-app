<?php

namespace App\Http\Filter;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AnswerFilter extends BaseFilter
{
    protected array $filters = [
        'sort'
    ];

    public function sort($sorts){

        foreach ($sorts as $sort) {
            [$column, $direction] = json_decode($sort, true);

            $this->validationBoolean($direction);

            try {

                if (str_contains($column, '.')) {
                    $this->customOrder($column,$direction);
                }else{
                    $this->builder->orderBy($column, $direction ? 'desc' : 'asc');
                }

            } catch (\Exception $exception) {
                throw new BadRequestException("Error sorting",$exception);
            }
        }
    }
    private function customOrder(string $column,bool $direct): void
    {
        if ($jsonColumn=explode('.',$column)[1]??null){
            $this->builder->orderByRaw("schema->'{$jsonColumn}'->>'value' {$column}");
        }
    }
}
