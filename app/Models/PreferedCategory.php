<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferedCategory extends Model
{
    use HasFactory;
  
    protected  $table = 'user_preference_category';

    protected $fillable = [
        'user_id','category_id','created_at','updated_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at', 
    ];
}