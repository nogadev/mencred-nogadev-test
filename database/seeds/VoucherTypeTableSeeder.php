<?php

use Illuminate\Database\Seeder;

class VoucherTypeTableSeeder extends Seeder
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
                'code'          =>  '001',
                'description'   =>  'FACTURA A',
                'acronym'       =>  'FC-A'
            ),
            array(
                'id'            =>  2,
                'code'          =>  '002',
                'description'   =>  'NOTA DE DEBITO A',
                'acronym'       =>  'ND-A'
            ),
            array(
                'id'            =>  3,
                'code'          =>  '003',
                'description'   =>  'NOTA DE CREDITO A',
                'acronym'       =>  'NC-A'
            ),
            array(
                'id'            =>  4,
                'code'          =>  '004',
                'description'   =>  'RECIBO A',
                'acronym'       =>  'RB-A'
            ),
            array(
                'id'            =>  5,
                'code'          =>  '006',
                'description'   =>  'FACTURA B',
                'acronym'       =>  'FC-B'
            ),
            array(
                'id'            =>  6,
                'code'          =>  '007',
                'description'   =>  'NOTA DE DEBITO B',
                'acronym'       =>  'ND-B'
            ),
            array(
                'id'            =>  7,
                'code'          =>  '008',
                'description'   =>  'NOTA DE CREDITO B',
                'acronym'       =>  'NC-B'
            ),
            array(
                'id'            =>  8,
                'code'          =>  '009',
                'description'   =>  'RECIBO B',
                'acronym'       =>  'RB-B'
            ),
            array(
                'id'            =>  9,
                'code'          =>  '011',
                'description'   =>  'FACTURA C',
                'acronym'       =>  'FC-C'
            ),
            array(
                'id'            =>  10,
                'code'          =>  '012',
                'description'   =>  'NOTA DE DEBITO C',
                'acronym'       =>  'ND-C'
            ),
            array(
                'id'            =>  11,
                'code'          =>  '013',
                'description'   =>  'NOTA DE CREDITO C',
                'acronym'       =>  'NC-C'
            ),
            array(
                'id'            =>  12,
                'code'          =>  '015',
                'description'   =>  'RECIBO C',
                'acronym'       =>  'RB-C'
            ),
            array(
                'id'            =>  13,
                'code'          =>  '999',
                'description'   =>  'REMITO',
                'acronym'       =>  'REMITO'
            )
        );

        DB::table('voucher_types')->insert($data);
    }
}
