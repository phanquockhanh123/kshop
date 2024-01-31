<?php

namespace App\Services;

use Exception;
use App\Models\Campaign;
use App\Jobs\DelayCreateCampainJob;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CampaignRepository;
use Symfony\Component\HttpFoundation\Response;

class CampaignService implements CampaignServiceInterface
{
    protected $campaignRepository;

    /**
     * create a new instance
     *
     * @param CampaignRepository $campaignRepository
     */
    public function __construct(CampaignRepository $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    /**
     * get All Campaigns function
     *
     * @return array
     */
    public function getAllCampaigns()
    {
        $campaigns = $this->campaignRepository->getAll();
        return [Response::HTTP_OK, $campaigns];
    }

    /**
     * get detail campaign function
     *
     * @return array
     */
    public function detailCampaign($campaignId)
    {
        try {
            $campaign = $this->campaignRepository->detail($campaignId);
            return [Response::HTTP_OK, $campaign];
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
            $this->campaignRepository->delete($campaignId);
            return [Response::HTTP_OK, ['message' => 'Delete campaign successful!']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => $e]];
        }

    }

    public function createCampaign($data) {
        // Lưu ảnh
        if (!empty($data['filepath'])) {
            $profile = $data['filepath'];
            $filename = time() . '_' . $profile->getClientOriginalName();

            $uploadPath = public_path('/assests/img/campaigns') ;

            // Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true, true);
            }

            if (move_uploaded_file($profile, $uploadPath . '/' . $filename)) {
                $data['filepath'] = $uploadPath . '/' . $filename;
                $data['photo_name'] = $filename;
            } else {
                return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
            }
        }

        try {
            DelayCreateCampainJob::dispatch()->delay(now()->addMinutes(1));
            $this->campaignRepository->create($data);
            return [Response::HTTP_OK, ['message' => 'Create campaign successful!']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => $e]];
        }
    }

    /**
     * update campaign
     * @param  $data
     * @return array
     */
    public function updateCampaign($data)
    {
        $campaign = Campaign::where('id', $data['id'])->first();
        // Lưu ảnh
        if (!empty($data['filepath'])) {

            $profile = $data['filepath'];
            $filename = time() . '_' . $profile->getClientOriginalName();

            $uploadPath = public_path('/assests/img/campaigns') ;
            $imagePath = $uploadPath . '/' . $filename;
            // Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true, true);
            }

            if ($campaign->filepath) {
                unlink($campaign->filepath);
            }

            if (move_uploaded_file($profile, $imagePath)) {
                $data['filepath'] = $imagePath;
                $data['photo_name'] = $filename;
            } else {
                return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
            }
        }

        try {
            $this->campaignRepository->edit($data);
            return [Response::HTTP_OK, ['message' => 'Update discount successful!']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }
}
