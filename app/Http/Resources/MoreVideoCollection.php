<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\SubProduct;

class MoreVideoCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    
    public function toArray($request)
    {
        $get_vid = SubProduct::where('id',$this->video_id)->first('banner_image');
        return [
            'id' => $this->id, 
            'video_id' => $this->video_id, 
            'language_type_id' => $this->language_type_id, 
            'media_url' => ($this->media_url) ? url('uploads/'.$this->media_url) : "", 
            'banner_image' => (@$get_vid->banner_image) ? url('uploads/'.$get_vid->banner_image) : '',
        ];
    }
}
