<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'k56bkhn',
            'email' => 'phieubat1905@gmail.com',
            'status' => '1',
            'level' => '1',
            'password' => hash::make('anhemta'),
        ]);
        
        DB::table('users')->insert([
            'name' => 'k56bkhn',
            'email' => 'test@gmail.com',
            'status' => '1',
            'level' => '2',
            'password' => hash::make('1a'),
        ]);
        
        DB::table('cates')->insert([
            'name' => 'Liên Quân',
            'alias' => 'lien-quan',
            'status' => '1'
        ]);
        
        DB::table('product_atr')->insert([
            'name' => 'Tulen',
            'product_atr_cate_id' => 1,
            'status' => '1'
        ]);
        
        DB::table('product_atr_cates')->insert([
            'name' => 'Tướng',
            'alias' => 'tuong',
            'cate_id' => 1,
            'status' => '1'
        ]);
        
        for($i=0; $i<=200; $i++)
        {
            DB::table('products')->insert([
            'name' => 'Acc Liên Quân 130k',
            'alias'=>'abc',
            'price' => 120000,
            'price_atm' => 100000,
            'gold' => 10000,
            'qh'=>20,
            'image'=>'UntitledQA5CJqYhrB.png',
            'status'=>1,
            'cate_id'=>1,
            'user_id'=>''
            ]);
        }       
        
    }
}
