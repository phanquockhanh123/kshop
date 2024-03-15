<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\FabbiServiceInterface;

class FabbiController extends BaseController
{
    protected $fabbiService;

    /**
     * Create a new instance
     *
     * @param fabbiServiceInterface $fabbiService
     */
    public function __construct(FabbiServiceInterface $fabbiService)
    {
        $this->fabbiService = $fabbiService;
    }

     /**
     * save data in json file
     *
     * @param Request $request
     * @return json
     */
    public function saveJson(Request $request)
    {
        list($statusCode, $data) = $this->fabbiService->saveJson($request->all());
        return $this->response($data, $statusCode);
    }
}
