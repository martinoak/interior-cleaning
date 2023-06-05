<?php

namespace App\Models\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatabaseFacade
{
    public function getFeedbacks(): Collection
    {
        return DB::table('feedback')->where([['rating', '>', 3]])->get();
    }

    public function setFeedbackSent(int $id): void
    {
        DB::table('customers')->where('id', $id)->update(['feedbackSent' => 1]);
    }
}
