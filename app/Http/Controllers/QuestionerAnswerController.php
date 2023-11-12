<?php

namespace App\Http\Controllers;

use App\Http\Filter\AnswerFilter;
use App\Http\Requests\AnswerStoreRequest;
use App\Http\Requests\AnswerUpdateRequest;
use App\Models\Answer;
use App\Models\Query\Fetch\QuestionerAnswerTableFetch;
use App\Models\Questioner;
use App\Service\QuestionerValidate\QuestionerValidateService;
use App\Transformers\AnswerTransformer;
use App\Transformers\QuestionerAnswerTransformer;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class QuestionerAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Questioner $questioner, AnswerFilter $filter, QuestionerAnswerTableFetch $fetch): \Spatie\Fractal\Fractal
    {
        return fractal(
            $fetch->handler($questioner)
                ->filter($filter)
                ->get(),
            new QuestionerAnswerTransformer()
        );
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(AnswerStoreRequest $request, Questioner $questioner, QuestionerValidateService $questionerValidateService): \Spatie\Fractal\Fractal
    {
        $questionerValidateService->setFormRequest($request->input('schema'));
        if (!$questionerValidateService->validationByOriginal($questioner) || !$questionerValidateService->isValid()) {
            throw new  BadRequestException("Error Store Answer");
        }
        return fractal($questioner->answers()->create($request->validated()), new AnswerTransformer());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnswerUpdateRequest $request, Questioner $questioner, Answer $answer, QuestionerValidateService $questionerValidateService): \Spatie\Fractal\Fractal
    {
        $questionerValidateService->setFormRequest($request->input('schema'));
        if (!$questionerValidateService->validationByOriginal($questioner) || !$questionerValidateService->isValid()) {
            throw new  BadRequestException("Error Store Answer");
        }
        $answer->update($request->validated());
        return fractal($answer->refresh(), new AnswerTransformer());
    }
}
