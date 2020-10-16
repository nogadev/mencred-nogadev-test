<?php

use Illuminate\Database\Seeder;


class MovTypesTableSeeder extends Seeder
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
                'description'          =>  'INGRESO'
            ),
            array(
                'id'            =>  2,
                'description'          =>  'EGRESO'
            ),
        );
        DB::table('mov_types')->insert($data);
    }
}
