<?php

namespace App\Http\Controllers\API\Admin;

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
    public function index()
    {
        list($statusCode, $data) = $this->campaignService->getAllCampaigns();

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
        list($statusCode, $data) = $this->campaignService->updateCampaign($data);

        return $this->response($data, $statusCode);
    }
}
