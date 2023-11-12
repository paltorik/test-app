<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateStoreRequest;
use App\Http\Requests\CandidateUpdateRequest;
use App\Models\Candidate;
use App\Transformers\CandidateTransformer;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Spatie\Fractal\Fractal
    {
        return fractal(Candidate::all(), new CandidateTransformer());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CandidateStoreRequest $request)
    {

        return fractal(Candidate::create($request->validated()), new CandidateTransformer());
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        return fractal($candidate, new CandidateTransformer());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CandidateUpdateRequest $request, Candidate $candidate)
    {
        if ($candidate->update($request->validated())) {
            return fractal($candidate, new CandidateTransformer());
        }
        throw new  BadRequestException("Error update Candidate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        if (!$candidate->delete()) {
            throw new  BadRequestException("Error update Candidate");
        }
    }
}
