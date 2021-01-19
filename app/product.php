<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = 'products';

    protected $fillable = 
    ['name',
    'alias',
    'price',
    'price_atm',
    'gold',
    'qh',
    'rank',
    'sell',
    'acc_buy',
    'time_buy',
    'intro',
    'content',
    'image',
    'keywords',
    'description',
    'status',
    'user_id',
    'cate_id',
    'sale_off'];

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
