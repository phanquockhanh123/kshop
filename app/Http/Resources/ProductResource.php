<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'status' => $this->status,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'supplier' => $this->supplier,
            'tags' => $this->tags,
            'price' => $this->price,
            'price_compare' => $this->price_compare,
            'is_ship' => $this->is_ship,
            'weight' => $this->weight
        ];
    }
}
