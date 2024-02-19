<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Services\ColorServiceInterface;
use App\Http\Requests\CreateColorRequest;
use App\Http\Requests\UpdateColorRequest;
use App\Http\Controllers\API\BaseController;

class ColorController extends BaseController
{
    protected $colorService;

    /**
     * create a new instance
     *
     * @param ColorServiceInterface $colorService
     */
    public function __construct(ColorServiceInterface $colorService)
    {
        $this->colorService = $colorService;
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
        list($statusCode, $data) = $this->colorService->getAllColors($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * detail Color
     * @param  int $id
     *
     * @return json
     */
    public function detail(int $id)
    {
        list($statusCode, $data) = $this->colorService->detailColor($id);

        return $this->response($data, $statusCode);
    }

    /**
     * create Color
     * @param  CreateColorRequest $request
     *
     * @return json
     */
    public function create(Request $request)
    {
        list($statusCode, $data) = $this->colorService->createColor($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * update Color
     * @param  UpdateColorRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(Request $request, int $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        list($statusCode, $data) = $this->colorService->updateColor($data);

        return $this->response($data, $statusCode);
    }

    /**
     * delete Color
     * @param  int $id
     *
     * @return json
     */
    public function delete($id)
    {

        list($statusCode, $data) = $this->colorService->deleteColor($id);

        return $this->response($data, $statusCode);
    }
}
