<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PreferedCategory; 
use Auth;
class CategoryCollection extends JsonResource
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
        
        $pref_count = PreferedCategory::where(['user_id' => $auth_id,'category_id' => $this->id])->count();
        $is_prefered_cat = ($pref_count>0) ? '1' : '0';
        return [
            'category_id' => $this->id,
            'category_name' => $this->category_name, 
            'category_image' => ($this->category_image) ? url('uploads/'.$this->category_image) : "", 
            'is_prefered_category' => $is_prefered_cat, 
        ];
    }
}
