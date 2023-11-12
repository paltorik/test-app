<?php

namespace App\Models\Query\Fetch;

use App\Models\Questioner;

final class QuestionerAnswerTableFetch
{
    public function handler(Questioner $questioner): \Illuminate\Database\Eloquent\Builder
    {
        return $questioner
            ->answers()
            ->getQuery()
            ->join('candidates','answers.candidate_id','candidates.id')
            ->join('users','users.id','candidates.user_id')
            ->select('answers.*','users.*','candidates.*');
    }
}
