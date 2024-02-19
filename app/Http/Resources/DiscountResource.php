<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
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
            'discount_code' => $this->discount_code,
            'discount_type' => $this->discount_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'discount_value' => $this->discount_value,
            'status' => $this->status,
            'created_at' => Carbon::parse( $this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse( $this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
