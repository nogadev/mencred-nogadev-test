<?php

use Illuminate\Database\Seeder;

class ReasonTableSeeder extends Seeder
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
                'reason'          =>  'SIN DINERO'
            ),
            array(
                'id'            =>  2,
                'reason'          =>  'CERRADO'
            ),
            array(
                'id'            =>  3,
                'reason'          =>  'SEMANAL'
            ),
            array(
                'id'            =>  4,
                'reason'          =>  'DIA POR MEDIO'
            ),
            array(
                'id'            =>  5,
                'reason'          =>  'PROBLEMA'
            ),
            array(
                'id'            =>  6,
                'reason'          =>  'ADELANTADO'
            ),
            array(
                'id'            =>  7,
                'reason'          =>  'OTRO'
            ),
            array(
                'id'            =>  8,
                'reason'          =>  'FERIADO'
            )              
        );
        DB::table('reasons')->insert($data);
    }
}
