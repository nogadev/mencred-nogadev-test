<?php

use Illuminate\Database\Seeder;

class MovReasonSeeder extends Seeder
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
                'description'   =>  'RENDICION COBRANZA',
                'mov_type_id'   =>  1,
                'available'     =>  0
            ),
            array(
                'id'            =>  2,
                'description'   =>  'CUOTA INICIAL',
                'mov_type_id'   =>  1,
                'available'     =>  0
            ),
//            array(
//                'id'            =>  3,
//                'description'   =>  'EGRESO DE CHEQUE',
//                'mov_type_id'   =>  2
//            ),
//            array(
//                'id'            =>  4,
//                'description'   =>  'EGRESO DE MERCADO PAGO',
//                'mov_type_id'   =>  2
//            ),
            array(
                'id'            =>  5,
                'description'   =>  'CHEQUE',
                'mov_type_id'   =>  1,
                'available'     =>  0
            ),
            array(
                'id'            =>  6,
                'description'   =>  'MERCADO PAGO',
                'mov_type_id'   =>  1,
                'available'     =>  0
            ),
            array(
                'id'            =>  7,
                'description'   =>  'BANCO',
                'mov_type_id'   =>  1,
                'available'     =>  0
            ),
            array(
                'id'            =>  8,
                'description'   =>  'APERTURA CAJA',
                'mov_type_id'   =>  1,
                'available'     =>  0
            )
        );
        DB::table('mov_reasons')->insert($data);
    }
}
