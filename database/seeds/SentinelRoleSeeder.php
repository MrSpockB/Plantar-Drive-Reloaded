<?php

use Illuminate\Database\Seeder;

class SentinelRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Usuarios',
            'slug' => 'usuarios',
        ]);
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Admins',
            'slug' => 'admins',
        ]);
        $this->command->info('Roles seeded!');
    }
}
