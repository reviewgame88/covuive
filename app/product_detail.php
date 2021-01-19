<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_detail extends Model
{
    protected $table = 'product_detail';

    protected $fillable = ['id','product_id','product_atr_id'];

    public $timestamps = true;
    
}
