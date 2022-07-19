<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
use App\Models\User; 
use App\Models\Product; 
use App\Models\ReviewRating;
use Auth;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProduct extends Model
{
    use HasFactory,SoftDeletes;
  
    protected  $table = 'sub_products';

    protected $fillable = [
        'id','sub_product_title','category_id','product_id','banner_image','sub_media_url','year','sub_product_description','u_a','status','video_type','created_at','updated_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at', 
    ]; 

    protected $appends = [
         'rating_avg' 
    ];

    public function product_detail()  // use as sub category
    {       
        return $this->hasOne(Product::class, 'id','product_id');
    } 

    public function category_detail()
    {       
        return $this->hasOne(Category::class, 'id','category_id');
    }   

    public function getSubProductStatusNameAttribute()
    {      
        $status_id = $this->status;

        if($status_id=='1')
           $status = "Active"; 
        else 
            $status = "InActive";

        return $status;
    } 

    public function getSubProductTypeNameAttribute()
    {      
        $type = $this->video_type;

        if($type=='1')
            $status = "Trending"; 
        else if($type=='2')
            $status = "Popular"; 
        else if($type=='3')
            $status = "Upcoming";
        else 
            $status = "Active";

        return $status;
    }

    public function getRatingAvgAttribute(){
        $crr = ReviewRating::select(DB::raw('COALESCE(avg(rating),0) as avg_ratting'))->where('sub_product_id',$this->id)->first(); 
        return $crr->avg_ratting;
    }

    public function product_review()
    {       
        return $this->hasMany(ReviewRating::class, 'sub_product_id','id');
    }
}