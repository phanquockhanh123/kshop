<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FabbiService implements FabbiServiceInterface
{
    public function saveJson(array $data)
    {
        try {
            dd(12);
            if (file_exists(storage_path('./storage/app/dishes.json'))) {
                $json = File::get(storage_path('app/dishes.json'));
                $oldData = json_decode($json, true);
                $data = [$oldData, $data];
            }
            Storage::disk('local')->put('dishes.json', json_encode($data));
        } catch (\Throwable $th) {
            \Log::error($th);

            return [
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [
                    'message' => 'Lỗi ghi vào file'
                ]
            ];
        }
        return [Response::HTTP_OK, []];
    }
}
