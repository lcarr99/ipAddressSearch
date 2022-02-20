<?php


namespace App\Repository;

use App\Models\IPSearch;

class IPSearchRepository
{
    public static function create(string $searchValue, string $response): IPSearch
    {
        return IPSearch::create(['searchValue' => $searchValue, 'response' => $response]);
    }
}
