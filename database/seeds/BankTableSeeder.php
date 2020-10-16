<?php

use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder
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
                'name'          =>  'MERCADO PAGO'
            ),
            array(
                'id'            =>  2,
                'name'          =>  'NACION'
            ),
            array(
                'id'            =>  3,
                'name'          =>  'ICBC'
            ),
            array(
                'id'            =>  4,
                'name'          =>  'GALICIA'
            ),
            array(
                'id'            =>  5,
                'name'          =>  'MACRO'
            ),
            array(
                'id'            =>  6,
                'name'          =>  'CREDICOOP'
            ),
            array(
                'id'            =>  7,
                'name'          =>  'SANTANDER RIO'
            ),
            array(
                'id'            =>  8,
                'name'          =>  'HSBC'
            ),
            array(
                'id'            =>  9,
                'name'          =>  'ARGENPER'
            ),
            array(
                'id'            =>  10,
                'name'          =>  'WESTERN UNION'
            ),
            array(
                'id'            =>  11,
                'name'          =>  'HIPOTECARIO'
            ),
            array(
                'id'            =>  12,
                'name'          =>  'BBVA'
            ),
            array(
                'id'            =>  13,
                'name'          =>  'SUPERVIELLE'
            ),array(
                'id'            =>  14,
                'name'          =>  'SAN JUAN'
            ),array(
                'id'            =>  15,
                'name'          =>  'SANCOR'
            ),array(
                'id'            =>  16,
                'name'          =>  'COLUMBIA'
            ),array(
                'id'            =>  17,
                'name'          =>  'COMAFI'
            ),array(
                'id'            =>  18,
                'name'          =>  'DHL'
            ),array(
                'id'            =>  19,
                'name'          =>  'ITAU'
            ),array(
                'id'            =>  20,
                'name'          =>  'MENDOZA'
            ),array(
                'id'            =>  21,
                'name'          =>  'INDUSTRIAL'
            ),array(
                'id'            =>  22,
                'name'          =>  'SERVICIOS Y TRANSACCIONES'
            )
        );
        DB::table('banks')->insert($data);
    }
}