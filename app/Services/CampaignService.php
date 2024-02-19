<?php

namespace App\Services;

use Exception;
use App\Models\Campaign;
use App\Jobs\DelayCreateCampainJob;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CampaignResource;
use App\Repositories\CampaignRepository;
use Symfony\Component\HttpFoundation\Response;

class CampaignService implements CampaignServiceInterface
{

    /**
     * get All Campaigns function
     *
     * @return array
     */
    public function getAllCampaigns(array $filter,array $paginate)
    {
        $query = Campaign::query();

        if (!empty($filter['query'])) {
            $query = $query->whereRaw($filter['query']);
        }

        if ($filter['sort_fields']) {
            $query = $query->orderBy($filter['sort_fields'], $filter['sort_order']);
        }

        $data = $query->orderBy('updated_at', 'DESC')
            ->paginate($paginate['per_page'], ['*'], 'page', $paginate['page']);

        return [Response::HTTP_OK, $data->toArray()];
    }

    /**
     * get detail campaign function
     *
     * @return array
     */
    public function detailCampaign($campaignId)
    {
        try {
            $campaign = Campaign::findOrFail($campaignId);
            $data = (new CampaignResource($campaign))->toArray();
            return [Response::HTTP_OK, $data];
        } catch (Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['errors' => $e]];
        }
    }

    /**
     * delete campaign function
     *
     * @return array
     */
    public function deleteCampaign($campaignId)
    {
        try {
            $campaign = Campaign::find($campaignId);
            if ($campaign) {
                $campaign->delete();
                return [Response::HTTP_OK, ['message' => 'This record has deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, [
                    'message' => 'This record not found.'
                ]];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => $e]];
        }

    }

    public function createCampaign($data) {
        $dataSave = $data;

        if (!empty($data['image'])) {
            $image = uploadImage($data['image'], '/img/campaigns');
           
            $dataSave['image'] = $image;
        }

        try {
            $dataSave['status'] = Campaign::STATUS_ACTIVE;
            Campaign::create($dataSave);
            return [Response::HTTP_OK, ['message' => 'Campaign created successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update campaign
     * @param  $data
     * @return array
     */
    public function updateCampaign($data)
    {
        $campaign = Campaign::findOrFail($data['id']);
        $dataSave = $data;

        if (!empty($data['image'])) {
            deleteImageLocalStorage($campaign->image);
            $image = uploadImage($data['image'], '/img/campaigns');
           
            $dataSave['image'] = $image;
        }

        try {
            $campaign->update($dataSave);
            return [Response::HTTP_OK, ['message' => 'Campaign updated successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }
}
