<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at' => Carbon::parse( $this->created_at)->format('d-m-Y'),
            'updated_at' => Carbon::parse( $this->updated_at)->format('d-m-Y'),
        ];
    }
}
