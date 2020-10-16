<?php

use Illuminate\Database\Seeder;

class ExpenseConceptsTableSeeder extends Seeder
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
                'name'  =>  'PREVISIONES',//Guardar Negativo
                'subtract' => -1
            ),
            array(
                'id'	=>  2,
                'name' 	=>  'VALES',//Guardar Negativo
                'subtract' => -1
            ),
            array(
                'id'	=>  3,
                'name' 	=>  'ARTÍCULOS',//Guardar Negativo
                'subtract' => -1
            ),
            array(
                'id'	=>  4,
                'name' 	=>  'CRÉDITOS',//Guardar Negativo
                'subtract' => -1
            ),
            array(
                'id'	=>  5,
                'name' 	=>  'PREMIOS',//Guardar Positivo
                'subtract' => 1
            ),
            array(
                'id'	=>  6,
                'name' 	=>  'VIÁTICOS',//Guardar Positivo
                'subtract' => 1
            ),
            array(
                'id'	=>  7,
                'name' 	=>  'AGUINALDO',//Guardar Positivo
                'subtract' => 1
            ),
            array(
                'id'	=>  8,
                'name' 	=>  'VACACIONES',//Guardar Positivo
                'subtract' => 1
            ),
            array(
                'id'	=>  9,
                'name' 	=>  'RETIRO',//Guardar Negativo
                'subtract' => -1
            ),
        );
        DB::table('expense_concepts')->insert($data);
    }
}
