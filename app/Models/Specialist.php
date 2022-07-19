<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialist extends Model
{
    use HasFactory,SoftDeletes;
  
    protected  $table = 'specialist_tbl';

    protected $fillable = [
        'category_id','specialist_name','status','created_at','updated_at','deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at', 
    ];

    protected $appends = [
        'feature_status_name','category_data'
    ];

    public function getFeatureStatusNameAttribute()
    {      
        $status_id = $this->status;

        if($status_id=='1')
           $status = "Active"; 
        else 
            $status = "InActive";

        return $status;
    } 

    public function getCategoryDataAttribute()
    {
        $getResult = Category::where('id',$this->category_id)->first();

        return $getResult;
    }
}