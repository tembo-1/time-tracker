<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait SearchableModel
{
    public function scopeSearch($query, $search, $fields)
    {
        $fields = implode(',', $fields);

        $query
            ->select("$query->from.*", DB::raw("MATCH($fields) AGAINST('$search' IN BOOLEAN MODE) as relevance"))
            ->whereRaw("MATCH($fields) AGAINST('$search' IN BOOLEAN MODE)")
            ->orderBy('relevance', 'DESC');
    }
}
