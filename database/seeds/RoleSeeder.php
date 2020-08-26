<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Ability;
use App\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ability = Ability::create([
            'name' => 'all'
        ]);

        $role = Role::create([
            'name'=>'admin'
        ]);
        
        $role->assignAbility($ability);
        $user = User::first()->assignRole($role);

        
    }
}
