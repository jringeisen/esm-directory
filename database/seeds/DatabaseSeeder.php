<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Role::class)->create(['name' => 'admin']);
        factory(Role::class)->create(['name' => 'photographer']);
        factory(Role::class)->create(['name' => 'client']);
    }
}
