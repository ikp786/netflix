<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class SliderCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    
    public function toArray($request)
    {
        return [
            'slider_id' => $this->id, 
            'slider_image' => ($this->slider_image) ? url('uploads/'.$this->slider_image) : "",
            'video_id' => ($this->video_id) ? $this->video_id : "", 
            'video_url' => ($this->video_url) ? $this->video_url : "", 
        ];
    }
}
