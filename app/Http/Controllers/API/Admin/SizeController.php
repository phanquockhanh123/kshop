<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Services\SizeServiceInterface;
use App\Http\Requests\CreateSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use App\Http\Controllers\API\BaseController;

class SizeController extends BaseController
{
    protected $sizeService;

    /**
     * create a new instance
     *
     * @param SizeServiceInterface $sizeService
     */
    public function __construct(SizeServiceInterface $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    /**
     * get categories list
     *
     * @return json
     */
    public function index(Request $request)
    {
        $request->validate([
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'sort_fields' => 'nullable|string|in:created_at,updated_at',
            'sort_order' => 'nullable|string|in:desc,asc'
        ]);

        $params = $request->all();
        $paginate = [
            'page' => $params['page'] ?? 1,
            'per_page' => $params['per_page'] ?? 8
        ];

        $filter = [
            'sort_fields' => $params['sort_fields'] ?? null,
            'sort_order' => $params['sort_order'] ?? 'ASC',
        ];
        list($statusCode, $data) = $this->sizeService->getAllSizes($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * detail Size
     * @param  int $id
     *
     * @return json
     */
    public function detail(int $id)
    {
        list($statusCode, $data) = $this->sizeService->detailSize($id);

        return $this->response($data, $statusCode);
    }

    /**
     * create Size
     * @param  CreateSizeRequest $request
     *
     * @return json
     */
    public function create(CreateSizeRequest $request)
    {
        list($statusCode, $data) = $this->sizeService->createSize($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * update Size
     * @param  UpdateSizeRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(UpdateSizeRequest $request, int $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        list($statusCode, $data) = $this->sizeService->updateSize($data);

        return $this->response($data, $statusCode);
    }

    /**
     * delete Size
     * @param  int $id
     *
     * @return json
     */
    public function delete($id)
    {

        list($statusCode, $data) = $this->sizeService->deleteSize($id);

        return $this->response($data, $statusCode);
    }
}
