<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class MoreVideo extends Model
{
    use HasFactory;
  
    protected  $table = 'more_video_tbl';

    protected $fillable = [
        'video_id','language_type_id','media_url','created_at','updated_at'
    ];

    protected $hidden = [ 
        'updated_at' 
    ];
}