<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
use App\Models\ReviewRating;
use App\Models\Category; 
use App\Models\Product; 

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
  
    protected  $table = 'products';

    protected $fillable = [
        'id','product_name','category_id','year','media_url','description','status','created_at','updated_at','deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at', 
    ];
 
    public function category_detail()
    {       
        return $this->hasOne(Category::class, 'id','category_id');
    }   
 
    public function getProductStatusNameAttribute()
    {      
        $status_id = $this->status;

        if($status_id=='1')
           $status = "Active"; 
        else 
            $status = "InActive";

        return $status;
    } 

    public function product_review()
    {       
        return $this->hasMany(ReviewRating::class, 'sub_product_id','id');
    }
}