<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource; 

use Auth;
use App\Models\Favourite;   
use App\Models\ReviewRating;

class SubProductCollection extends JsonResource
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
 
        $review_rating_list = ReviewRating::leftjoin('users','users.id','=','review_rating.user_id')->where(['review_rating.sub_product_id' => $this->id])->get(['review_rating.id','review_rating.user_id','users.name','users.profile_photo_path','review_rating.rating','review_rating.comment','review_rating.created_at'])->toArray();
        $review_rating_count = count($review_rating_list);
        
        $my_review_count = ReviewRating::where(['user_id' => $auth_id,'sub_product_id' => $this->id])->count();
        $is_my_review = ($my_review_count>0) ? '1' : '0';
        return [
            'video_id' => $this->id,
            'video_name' => $this->sub_product_title,   
            'category_id' => $this->category_detail->id,
            'category_name' => $this->category_detail->category_name,
            'sub_category_id' => $this->product_detail->id,
            'sub_category_name' => $this->product_detail->product_name,  
            'video_rating' => $this->rating_avg ?? '0',   
            'review_rating_count' => $review_rating_count,    
            'review_rating_list' => $review_rating_list,                
            'description' => $this->sub_product_description, 
            'banner_image' => (@$this->banner_image) ? url('uploads/'.$this->banner_image) : '',
            'media_url' => (@$this->sub_media_url) ? url('uploads/'.$this->sub_media_url) : '',
            'video_status' => $this->sub_product_status_name, 
            'u_a' => $this->u_a,  
            'year' => $this->year, 
            'is_favourite' => $fav_prop_count, 
            'is_my_review'=>$is_my_review,         
            'updated_at' => date('Y-m-d h:m a',strtotime($this->updated_at)), 
        ];
        
        
    }

   
}
