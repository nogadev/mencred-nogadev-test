<?php

use Illuminate\Database\Seeder;

class EntityTypeSeeder extends Seeder
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
                'id'    =>  1,
                'name'  =>  'ARTICLE'
            ),
            array(
                'id'	=>  2,
                'name' 	=>  'INVOICE'
            )
        );

        DB::table('entity_types')->insert($data);
    }
}
