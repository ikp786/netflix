<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
  
    protected  $table = 'notification_table';

    protected $fillable = [
        'user_id','message','status','property_id','created_at','updated_at'
    ];

    protected $hidden = [ 
        'updated_at',
        'deleted_at', 
    ];
 
}
