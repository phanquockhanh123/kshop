<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Services\CampaignServiceInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CreateCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;

class CampaignController extends BaseController
{
    protected $campaignService;

    /**
     * create a new instance
     *
     * @param CampaignServiceInterface $campaignService
     */
    public function __construct(CampaignServiceInterface $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    /**
     * get campaigns list
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
        list($statusCode, $data) = $this->campaignService->getAllCampaigns($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * detail campaign
     * @param  int $id
     *
     * @return json
     */
    public function detail(int $id)
    {
        list($statusCode, $data) = $this->campaignService->detailCampaign($id);

        return $this->response($data, $statusCode);
    }

    /**
     * delete campaign
     * @param  int $id
     *
     * @return json
     */
    public function deleteCampaign(int $id)
    {
        list($statusCode, $data) = $this->campaignService->deleteCampaign($id);

        return $this->response($data, $statusCode);
    }

    /**
     * create campaign
     * @param CreateCampaignRequest $request
     *
     * @return json
     */
    public function create(CreateCampaignRequest $request)
    {
        list($statusCode, $data) = $this->campaignService->createCampaign($request->all());

        return $this->response($data, $statusCode);
    }

     /**
     * update campaign
     * @param  UpdateCampaignRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(UpdateCampaignRequest $request, int $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        $data['_method'] = 'patch';

        list($statusCode, $data) = $this->campaignService->updateCampaign($data);

        return $this->response($data, $statusCode);
    }
}
