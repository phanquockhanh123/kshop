<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FabbiService implements FabbiServiceInterface
{
    public function saveJson(array $data)
    {
        $resultSave = [];
        $saveData = [];
        $id = 1;

        foreach ($data['dishes'] as $dt) {
            $jsonDishes = json_decode($dt['dishes'], true);

            foreach ($jsonDishes as $dish) {
                $saveData[] = [
                    'id' => $id,
                    'name' => $dish,
                    'restaurant' => $dt['restaurant'],
                    'availableMeals' => [$dt['meal']]
                ];
            }
            $id++;
        }

        // Now, let's group dishes by name and merge available meals
        $groupedData = [];
        foreach ($saveData as $item) {
            $name = $item['name'];
            if (!isset($groupedData[$name])) {
                $groupedData[$name] = $item;
            } else {
                $groupedData[$name]['availableMeals'] = array_merge($groupedData[$name]['availableMeals'], [$item['availableMeals'][0]]);
            }
        }

        // Re-index the grouped data
        $groupedData = array_values($groupedData);

        try {
            $filePath = 'dishes.json';
            if (Storage::exists($filePath)) {
                $json = File::get(storage_path('app/dishes.json'));
                $oldData = json_decode($json, true);
                $resultSave['dishes'] = array_merge($oldData['dishes'] ?? [], $groupedData);
            } else {
                $resultSave['dishes'] = $groupedData;
            }

            Storage::disk('local')->put('dishes.json', json_encode($resultSave));
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
