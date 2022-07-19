<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class LanguageType extends Model
{
    use HasFactory;
  
    protected  $table = 'video_language_tbl';

    protected $fillable = [
        'language_title','created_at','updated_at'
    ];

    protected $hidden = [ 
        'updated_at' 
    ];
}