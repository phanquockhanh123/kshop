<?php

namespace App\Services;

use App\Models\StoreInfo;
use Illuminate\Http\Response;

class StoreInfoService implements StoreInfoServiceInterface
{
    /**
     * create StoreInfo
     * @param  $data
     * @return array
     */
    public function createStoreInfo($data)
    {
        try {
            StoreInfo::create($data);
            return [Response::HTTP_OK, ['message' => 'StoreInfo created successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update StoreInfo
     * @param  $data
     * @return array
     */
    public function updateStoreInfo($data)
    {
        $storeInfo = StoreInfo::get()[0];

        try {
            $storeInfo->update($data);
            return [Response::HTTP_OK, ['message' => 'StoreInfo updated successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }
}
