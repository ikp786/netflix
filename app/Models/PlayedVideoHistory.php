<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class PlayedVideoHistory extends Model
{
    use HasFactory;
  
    protected  $table = 'played_video_history';

    protected $fillable = [
        'user_id','video_id','created_at','updated_at'
    ];

    protected $hidden = [ 
        'updated_at' 
    ];
}