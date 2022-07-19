<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource; 

use Auth;
use App\Models\Favourite;   

class SubProductDetailCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
 
    public function toArray($request)
    {   
        $auth_id = Auth::id();
 
        $fav_prop_count = Favourite::where(['user_id' => $auth_id,'sub_product_id' => $this->id])->count();
        
        return [
            'video_id' => $this->id,
            'video_name' => $this->sub_product_title,   
            'category_id' => $this->category_detail->id,
            'category_name' => $this->category_detail->category_name,
            'sub_category_id' => $this->product_detail->id,
            'sub_category_name' => $this->product_detail->product_name,  
            'video_rating' => $this->rating_avg ?? '0',    
            'is_liked' => ($fav_prop_count>0) ? '1' : '0',             
            'description' => $this->sub_product_description, 
            'media_url' => (@$this->sub_media_url) ? url('uploads/'.$this->sub_media_url) : '',
            'video_status' => $this->sub_product_status_name, 
            'year' => $this->year,           
            'updated_at' => date('Y-m-d h:m a',strtotime($this->updated_at)), 
        ];

        
    }

   
}
