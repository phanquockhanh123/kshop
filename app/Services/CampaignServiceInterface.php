<?php

namespace App\Services;

interface CampaignServiceInterface
{
    public function getAllCampaigns();

    public function detailCampaign($id);

    public function deleteCampaign($id);

    public function createCampaign($params);

    public function updateCampaign($params);
}
