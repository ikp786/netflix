<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationCollection extends JsonResource
{
    
    public function toArray($request)
    {   
        return [
            'notification_id' => $this->id, 
            'message' => $this->message, 
            'create_date' => date('Y-m-d h:m:a',strtotime($this->created_at)), 
        ];
    }
}
