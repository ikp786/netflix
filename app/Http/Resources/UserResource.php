<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Alergy;
use App\Models\SpecialMedication;   
use App\Models\Booking;   
use App\Models\Category;   

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user_id = $this->id;

        return [
            'user_id' => $this->id,
            'user_name' => $this->name ?? '', 
            'email' => $this->email ?? '', 
            'country_code' => $this->country_code ?? '',
            'country_flag_code' => $this->country_flag_code ?? '',
            'phone' => $this->phone ?? '',  
            'profile_image' => ($this->profile_photo_path) ? url('uploads/'.$this->profile_photo_path) : "",  
        ];         
    }
}
