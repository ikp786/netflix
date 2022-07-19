<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Download extends Model
{
    use HasFactory;
  
    protected  $table = 'download_tbl';

    protected $fillable = [
        'user_id','product_id','sub_product_id','created_at','updated_at'
    ];

    protected $hidden = [ 
        'updated_at' 
    ];
}