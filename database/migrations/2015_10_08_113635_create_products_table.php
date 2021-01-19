<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('alias');
            $table->integer('price');
            $table->integer('price_atm');
            $table->integer('gold');
            $table->integer('qh');
            $table->tinyInteger('rank');
            $table->tinyInteger('sell');
            $table->string('acc_buy');
            $table->integer('time_buy');
            $table->string('intro');
            $table->string('image');
            $table->string('keywords');
            $table->string('description');
            $table->tinyInteger('status');
            $table->text('content');
            $table->integer('sale_off')->default(0);
            $table->integer('user_id')->unsigned();

            $table->integer('cate_id')->unsigned();
            $table->foreign('cate_id')->references('id')->on('cates')->onDelete('cascade');
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
        Schema::drop('products');
    }
}
