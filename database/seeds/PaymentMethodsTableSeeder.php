<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
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
                'name'  =>   'EFECTIVO'
            ),
            array(
                'id'	=>  2,
                'name' 	=>  'CHEQUE'
            ),
            array(
                'id'	=>  3,
                'name' 	=>  'MERCADO PAGO'
            ),
            array(
                'id'	=>  4,
                'name' 	=>  'BANCO'
            )
        );

        DB::table('payment_methods')->insert($data);

    }
}
