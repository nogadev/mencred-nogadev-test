<?php

use Illuminate\Database\Seeder;

class CustomerCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'id'            =>  1,
                'name'          =>  'BASIC'
            ),
            array(
                'id'            =>  2,
                'name'          =>  'PREMIUM'
            ),
            array(
                'id'            =>  3,
                'name'          =>  'GOLD'
            ),
            array(
                'id'            =>  4,
                'name'          =>  'MOROSO'
            ),
        );
        DB::table('customer_categories')->insert($data);
    }
}
