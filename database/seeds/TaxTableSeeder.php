<?php

use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
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
                'name'          =>  '0%',
                'value'         =>  0.00
            ),
            array(
                'id'            =>  2,
                'name'          =>  '10,5%',
                'value'         =>  10.50
            ),
            array(
                'id'            =>  3,
                'name'          =>  '21%',
                'value'         =>  21.00
            ),
            array(
                'id'            =>  4,
                'name'          =>  '27%',
                'value'         =>  27.00
            ),
            array(
                'id'            =>  5,
                'name'          =>  'EXENTO',
                'value'         =>  0.00
            )
        );
        DB::table('taxes')->insert($data);
    }
}
