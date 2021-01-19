<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class test extends Model
{
    //
    
    protected $table = 'tests';
    
    protected $fillable = ['id','name','age','country'];
    
    public $timestamps = true;
    
    
}
