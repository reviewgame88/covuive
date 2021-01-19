<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyCard extends Model
{
    protected $fillable = ['user_id', 'id', 'amount','seri','pass_card','status' , 'card_type_id'];
    
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
