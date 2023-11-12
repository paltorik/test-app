<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionerStoreRequest;
use App\Http\Requests\QuestionerUpdateRequest;
use App\Models\Questioner;
use App\Service\QuestionerValidate\QuestionerValidateService;
use App\Transformers\QuestionerTransformer;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class QuestionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return fractal(Questioner::all(), new QuestionerTransformer());
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(QuestionerStoreRequest $request, QuestionerValidateService $questionerValidateService)
    {
        $questionerValidateService->setFormRequest($request->schema);

        if ($questionerValidateService->isValid()) {
            return fractal(Questioner::create($request->validated()), new QuestionerTransformer());
        }

        throw new  BadRequestException("Error Strore Questioner");

    }

    /**
     * Display the specified resource.
     */
    public function show(Questioner $questioner)
    {
        return fractal($questioner, new QuestionerTransformer());
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(QuestionerUpdateRequest $request, Questioner $questioner, QuestionerValidateService $questionerValidateService)
    {
        $questionerValidateService->setFormRequest($request->schema);

        if (!$questionerValidateService->isValidStructure()) throw new  BadRequestException("Error update Questioner");

        if ($questioner->update($request->validated())) {
            return fractal($questioner, new QuestionerTransformer());
        }
        throw new  BadRequestException("Error update Questioner");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Questioner $questioner)
    {
        if (!$questioner->delete()) {
            throw new  BadRequestException("Error Destroy Questioner");
        }
    }
}
