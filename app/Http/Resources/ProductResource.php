<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Http\Resources\ProductInfosResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'status' => $this->status,
            'supplier' => $this->supplier,
            'tags' => $this->tags,
            'price' => $this->price,
            'price_compare' => $this->price_compare,
            'is_ship' => $this->is_ship,
            'weight' => $this->weight,
            'created_at' => Carbon::parse( $this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse( $this->updated_at)->format('Y-m-d H:i:s'),
            'product_infos' => ProductInfosResource::collection($this->productInfos),
        ];
    }
}
