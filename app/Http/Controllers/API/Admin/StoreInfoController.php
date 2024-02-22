<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\CreateStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Services\StoreInfoServiceInterface;
use App\Http\Controllers\API\BaseController;

class StoreInfoController extends BaseController
{
    protected $storeService;

    /**
     * create a new instance
     *
     * @param StoreInfoServiceInterface $storeService
     */
    public function __construct(StoreInfoServiceInterface $storeService)
    {
        $this->storeService = $storeService;
    }

     /**
     * create Store
     * @param  CreateStoreRequest $request
     *
     * @return json
     */
    public function create(CreateStoreRequest $request)
    {
        list($statusCode, $data) = $this->storeService->createStoreInfo($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * update Store
     * @param  UpdateStoreRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(UpdateStoreRequest $request)
    {
        list($statusCode, $data) = $this->storeService->updateStoreInfo($request->all());

        return $this->response($data, $statusCode);
    }
}
