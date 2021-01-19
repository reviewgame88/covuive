<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_atr_cate extends Model
{
    protected $table = 'product_atr_cates';

    protected $fillable = ['id','name','alias','cate_id','status'];

    //public $timestamps = false;

    public function product_atr(){
        return $this->hasMany('App\product_atr');
    }
}
