<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource; 

use Auth; 

class SubProductApiCollection extends JsonResource
{  
    public function toArray($request)
    {   
        $auth_id = Auth::id();
  
        return [
            'video_id' => $this->id,
            'video_name' => $this->sub_product_title,   
            'banner_image' => (@$this->banner_image) ? url('uploads/'.$this->banner_image) : '',
            'media_url' => (@$this->sub_media_url) ? url('uploads/'.$this->sub_media_url) : '', 
            'created_at' => date('Y-m-d h:m a',strtotime($this->created_at)), 
        ];
        
        
    }

   
}
