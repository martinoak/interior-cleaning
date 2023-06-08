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

    public function setVariant(int $id, string $variant): int
    {
        return DB::table('customers')->where('id', $id)->update(['variant' => $variant]);
    }

    public function setFeedbackSent(int $id): int
    {
        return DB::table('customers')->where('id', $id)->update(['feedbackSent' => 1]);
    }
}
