<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
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
                'id' =>  1,
                'status' => 'A CONFIRMAR'
            ),
            array(
                'id' =>  2,
                'status' => 'OPERANDO'
            ),
            array(
                'id' =>  3,
                'status' => 'PAGARE'
            ),
            array(
                'id' =>  4,
                'status' => 'CANCELADO'
            ),
            array(
                'id' =>  5,
                'status' => 'EN PROBLEMA'
            ),
            array(
                'id' =>  6,
                'status' => 'RECHAZADO'
            ),
            array(
                'id' =>  7,
                'status' => 'PENDIENTE'
            ),
            array(
                'id' =>  8,
                'status' => 'RESUELTO'
            ),
            array(
                'id' =>  9,
                'status' => 'CARTERA'
            ),
            array(
                'id' =>  10,
                'status' => 'ENTREGADO'
            ),
            array(
                'id' =>  11,
                'status' => 'ABIERTA'
            ),
            array(
                'id' =>  12,
                'status' => 'CERRADA'
            ),
            array(
                'id' =>  13,
                'status' => 'CONTADO'
            )
        );
        DB::table('status')->insert($data);
    }
}
