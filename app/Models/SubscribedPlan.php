<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category; 

class SubscribedPlan extends Model
{
    use HasFactory,SoftDeletes;
  
    protected  $table = 'subscribed_plans';

    protected $fillable = [
        'subscription_plan_id','user_id','created_at','updated_at','deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at', 
    ]; 

    public function subscribed_plan_detail()
    {       
        return $this->hasOne(SubscriptionPlan::class, 'id','subscription_plan_id');
    }  
}