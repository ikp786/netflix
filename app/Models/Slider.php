<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory,SoftDeletes;
  
    protected  $table = 'slider';

    protected $fillable = [
        'slider_name','slider_type','slider_image','video_id','video_url','status','created_at','updated_at','deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at', 
    ];

    protected $appends = [
        'slider_status_name'
    ];

    public function getSliderStatusNameAttribute()
    {      
        $status_id = $this->status;

        if($status_id=='1')
           $status = "Active"; 
        else 
            $status = "InActive";

        return $status;
    } 
}