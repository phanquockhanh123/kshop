<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request=null)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'campaign_budget' => $this->campaign_budget,
            'status' => $this->status,
            'campaign_description' => $this->campaign_description,
            'created_at' => Carbon::parse( $this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse( $this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
