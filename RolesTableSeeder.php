<?php

use Illuminate\Database\Seeder;
use App\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Role::truncate();
        DB::table('roles')->insert(['title' => 'Admin']);
        DB::table('roles')->insert(['title' => 'User']);
        
    
    }
}
