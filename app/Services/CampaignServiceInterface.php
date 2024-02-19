<?php

namespace App\Services;

interface CampaignServiceInterface
{
    public function getAllCampaigns(array $filter,array $paginate);

    public function detailCampaign($id);

    public function deleteCampaign($id);

    public function createCampaign($params);

    public function updateCampaign($params);
}
