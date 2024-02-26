<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'email_address' => $this->email_address,
            'status' => $this->status,
            'telephone' => $this->telephone,
            'role' => $this->role,
            'image' => $this->image,
            'first_login_flag' => $this->first_login_flag,
            'created_at' => Carbon::parse( $this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse( $this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
