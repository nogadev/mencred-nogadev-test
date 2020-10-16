<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'users',
            'voucher_types',
            'taxes',
            'status',
            'reasons',
            'mov_types',
            'customer_categories',
            'expense_concepts',
            'payment_methods',
            'mov_reasons',
            'banks'
        ]);

        $this->call(UserTableSeeder::class);
        $this->call(VoucherTypeTableSeeder::class);
        $this->call(TaxTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(ReasonTableSeeder::class);
        $this->call(MovTypesTableSeeder::class);
        $this->call(CustomerCategoriesTableSeeder::class);
        $this->call(ExpenseConceptsTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(MovReasonSeeder::class);
        $this->call(BankTableSeeder::class);
    }


    public function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
 
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
 
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
