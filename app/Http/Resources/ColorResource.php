<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    public function toArray($request = null)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status
        ];
    }
}
