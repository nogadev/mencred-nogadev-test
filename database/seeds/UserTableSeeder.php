<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\User::class, 5)->create();

        $data = array(
            array(
                'name' => 'admin',
		        'email' => 'admin@mencred.com',
		        'email_verified_at' => now(),
		        'password' => bcrypt('d41lym4n4g3r'), 
            ),
            array(
                'name' => 'Daniel Lucero',
		        'email' => 'daniel.lucero@mencred.com',
		        'email_verified_at' => now(),
		        'password' => bcrypt('kukicata'), 
            ),
            array(
                'name' => 'Pablo Bustamante',
		        'email' => 'pablo.bustamante@mencred.com',
		        'email_verified_at' => now(),
		        'password' => bcrypt('1324PACB'), 
            ),
            array(
                'name' => 'Enzo Marino',
		        'email' => 'enzo.marino@mencred.com',
		        'email_verified_at' => now(),
		        'password' => bcrypt('enzo'), 
            ),
            array(
                'name' => 'Georgina Egaña',
		        'email' => 'georgina.egania@mencred.com',
		        'email_verified_at' => now(),
		        'password' => bcrypt('2501LM'), 
            ),
            array(
                'name' => 'Gonzalo Marino',
		        'email' => 'gonzalo.marino@mencred.com',
		        'email_verified_at' => now(),
		        'password' => bcrypt('a0305012'), 
            ),
            array(
                'name' => 'Emiliano Borquez',
		        'email' => 'emiliano.borquez@mencred.com',
		        'email_verified_at' => now(),
		        'password' => bcrypt('33157200'), 
            ),
        );
        DB::table('users')->insert($data);
    }
}


//$2y$10$XJD2HdbXtFpCAsM1pf.yoOxG8HxOm6EThaYa.v2RhKn49KorBES1y db
//$2y$10$Cb3KE2YLXH1czsQrEyHUuOuwQH1yN5lJXLyqHXTW5XbRqujsnFOY. make