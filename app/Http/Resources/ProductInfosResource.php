<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductInfosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request = null)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'size_id' => $this->size_id,
            'color_id' => $this->color_id,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'price_more' => $this->price_more,
            'quantity' => $this->quantity,
            'quantity_evail' => $this->quantity_evail,
            'created_at' => Carbon::parse( $this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse( $this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
