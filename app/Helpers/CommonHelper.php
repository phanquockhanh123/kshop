<?php

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

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
/**
 * upload image func
 *
 * @return string
 */
function uploadImage($dataImage, $path)
{
    // Lưu ảnh
    $filename = Str::uuid(time()) . '-' . trim($dataImage->getClientOriginalName(), ' ');
    $uploadPath = public_path($path);

    //Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
    if (!File::exists($uploadPath)) {
        File::makeDirectory($uploadPath, 0777, true, true);
    }

    if (move_uploaded_file($dataImage, $uploadPath . '/' . $filename)) {
        $image = $path . '/' . $filename;
        return  $image;
    } else {
        return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
    }
}

/**
 * delete image func
 *
 * @return string
 */
function deleteImageLocalStorage($image)
{
    if (!empty($image)) {
        Storage::delete($image);
        File::delete(public_path($image));
    }
}

/**
 * upload many image func
 *
 * @return string
 */
function uploadManyImage($dataImage, $path, $dataSave)
{
    // Lưu ảnh
    $filename = Str::uuid(time()) . '-' . trim($dataImage->getClientOriginalName(), ' ');
    $uploadPath = public_path($path);

    //Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
    if (!File::exists($uploadPath)) {
        File::makeDirectory($uploadPath, 0777, true, true);
    }

    if (move_uploaded_file($dataImage, $uploadPath . '/' . $filename)) {
        $dataSave['image'][] = $path . '/' . $filename;
        return  $dataSave;
    } else {
        return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
    }
}
