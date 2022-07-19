<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource; 

use Auth;
use App\Models\Favourite;   

class ProductCollection extends JsonResource
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
 
        $fav_prop_count = Favourite::where(['user_id' => $auth_id,'product_id' => $this->id,'sub_product_id' => $this->sub_product_id])->count();
   
        return [
            'video_id' => $this->id,
            'video_name' => $this->product_name,   
            'category_id' => $this->category_detail->id,
            'category_name' => $this->category_detail->category_name,  
            'video_rating' => $this->product_rating ?? '0',    
            'is_liked' => ($fav_prop_count>0) ? '1' : '0',             
            'description' => $this->description, 
            'media_url' => (@$this->media_url) ? url('uploads/'.$this->media_url) : '',
            'video_status' => $this->product_status_name, 
            'year' => $this->year,           
            'updated_at' => date('Y-m-d h:m a',strtotime($this->updated_at)), 
        ];
        
        
    }

   
}
