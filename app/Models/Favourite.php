<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Favourite extends Model
{
    use HasFactory;
  
    protected  $table = 'favourite_table';

    protected $fillable = [
        'user_id','product_id','sub_product_id','created_at','updated_at'
    ];

    protected $hidden = [ 
        'updated_at' 
    ];
}