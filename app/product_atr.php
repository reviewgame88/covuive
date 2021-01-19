<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_atr extends Model
{
    protected $table = 'product_atr';

    protected $fillable = ['id','name','product_atr_cate_id','status'];

    public $timestamps = true;

    public function cate(){
        return $this->belongsTo('App\cate');
    }
    public function product_image(){
        return $this->hasMany('App\product_image');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
