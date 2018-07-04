<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role([
            'name' => 'admin',
            'level' => 5,
        ]);

        $role->save();

        $role = new Role([
            'name' => 'guest',
            'level' => 0,
        ]);

        $role->save();

        $role = new Role([
            'name' => 'user',
            'level' => 1,
        ]);

        $role->save();
    }
}
