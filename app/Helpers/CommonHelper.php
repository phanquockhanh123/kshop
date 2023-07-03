<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

if (!function_exists('generateHashToken')) {
    /**
     * generate token func
     *
     * @return string
     */
    function generateHashToken()
    {
        $newAppKey = base64_decode(substr(config('app.key'), 7));
        return hash_hmac('sha256', Str::random(40), $newAppKey);
    }

    /**
     * Paginate for API
     *
     * @param LengthAwarePaginator $collectionList
     * @return array
     */
    function paginateAPI(LengthAwarePaginator $collectionList)
    {
        return [
            'page' => $collectionList->currentPage(),
            'limit' => $collectionList->perPage(),
            'total' => $collectionList->total(),
            'total_page' => $collectionList->lastPage(),
        ];
    }
}