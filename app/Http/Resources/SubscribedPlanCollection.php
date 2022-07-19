<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource; 

use Auth; 

class SubscribedPlanCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
 
    public function toArray($request)
    {   
        $price = $this->subscribed_plan_detail->price;
        $discount = $this->subscribed_plan_detail->discount_in_percent;
        
        $discount_price = ($discount!="") ? $price*($discount/100) : ''; 
        
        return [
            'subscribed_id' => $this->id,
            'subscription_plan_id' => $this->subscription_plan_id, 
            'plan_title' => $this->subscribed_plan_detail->plan_title,   
            'plan_for_month' => $this->subscribed_plan_detail->plan_for_month,   
            'price' => $this->subscribed_plan_detail->price,      
            'discount_in_percent' => $this->subscribed_plan_detail->discount_in_percent, 
            'discount_price' => $discount_price, 
            'created_at' => date('Y-m-d h:m a',strtotime($this->created_at)), 
        ];
        
        
    }

   
}
