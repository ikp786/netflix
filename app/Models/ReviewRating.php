<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewRating extends Model
{
    use HasFactory,SoftDeletes;
  
    protected  $table = 'review_rating';

    protected $fillable = [
        'user_id','sub_product_id','rating','comment','created_at','updated_at','deleted_at'
    ];

    protected $hidden = [ 
        'updated_at',
        'deleted_at', 
    ];
}