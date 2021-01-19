<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductAtr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_atr', function (Blueprint $table) {        
            $table->increments('id');
            $table->string('name');
            
            $table->integer('product_atr_cate_id')->unsigned();
            //$table->foreign('product_atr_cate_id')->references('id')->on('product_atr_cates')->onDelete('cascade');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_atr');
    }
}
