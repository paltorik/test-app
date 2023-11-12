<?php

namespace App\Transformers;

use App\Models\Candidate;
use League\Fractal\TransformerAbstract;

class CandidateTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Candidate $candidate)
    {
        return $candidate->toArray();
    }
}
