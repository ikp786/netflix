<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource; 

use Auth;
use App\Models\Favourite;   

class ProductApiCollection extends JsonResource
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
  
        return [
            'sub_category_id' => $this->id,
            'sub_category_name' => $this->product_name,   
            'image' => (@$this->media_url) ? url('uploads/'.$this->media_url) : '',
        ];
        
        
    }

   
}
