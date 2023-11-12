<?php

namespace App\Transformers;

use App\Models\Questioner;
use League\Fractal\TransformerAbstract;

class QuestionerTransformer extends TransformerAbstract
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
    public function transform(Questioner $questioner)
    {
        return $questioner->toArray();
    }
}
