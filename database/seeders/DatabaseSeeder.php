<?php

namespace Database\Seeders;

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
        /* Creating Default Roles */
        $this->call(RoleSeeder::class);

        /* Creating Default Admin User */
        \App\Models\User::factory(1)->create();

        /* Creating Countries */
        $this->call(CountrySeeder::class);

        /* Creating States */
        $this->call(StateSeeder::class);

        /* Creating Status */
        $this->call(StatusSeeder::class);

        /* Creating Categories */
        $this->call(CategorySeeder::class);

        /* Create Packages */
        $this->call(PackageSeeder::class);

        /* Creating Test Company */
        if(env('APP_ENV') == 'local')
        {
            $this->call(ComapnySeeder::class);
        }
    }
}
