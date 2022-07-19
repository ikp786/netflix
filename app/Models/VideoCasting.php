<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class VideoCasting extends Model
{
    use HasFactory;
  
    protected  $table = 'video_cast_tbl';

    protected $fillable = [
        'video_id','cast_image','cast_title','description','created_at','updated_at'
    ];

    protected $hidden = [ 
        'updated_at' 
    ];
}