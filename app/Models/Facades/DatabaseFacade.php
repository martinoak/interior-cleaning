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
}
