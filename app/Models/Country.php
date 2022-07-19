<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB; 

class Country extends Model
{
    use HasFactory;
  
    protected  $table = 'countries';

    protected $fillable = [
        'countries_id','countries_name','countries_iso_code','countries_isd_code'
    ];
}