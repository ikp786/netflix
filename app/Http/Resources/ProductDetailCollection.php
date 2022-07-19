<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource; 

use Auth;
use App\Models\Favourite;   

class ProductDetailCollection extends JsonResource
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
            'sub_product_id' => $this->id,
            'sub_product_name' => $this->sub_product_title,   
            'category_id' => $this->category_detail->id,             
            'sub_product_description' => $this->sub_product_description, 
            'sub_media_url' => (@$this->sub_media_url) ? url('uploads/'.$this->sub_media_url) : '',
            'sub_product_status' => $this->sub_product_status_name,          
            'updated_at' => date('Y-m-d h:m a',strtotime($this->updated_at)), 
        ];

        
    }

   
}
