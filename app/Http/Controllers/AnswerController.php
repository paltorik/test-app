<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Transformers\AnswerTransformer;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AnswerController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer): \Spatie\Fractal\Fractal
    {
        return fractal($answer, new AnswerTransformer());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer): void
    {
        if (!$answer->delete()) {
            throw new  BadRequestException("Error Destroy Answer");
        }
    }
}
