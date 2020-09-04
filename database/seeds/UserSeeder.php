<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $manager = Role::where('slug','manager')->first();
      $leader = Role::where('slug', 'leader')->first();
      $admin = Role::where('slug', 'admin')->first();

      $can_edit_vacation = Permission::where('slug','can_edit_vacation')->first();

      $Ivan = new User();
      $Ivan->name = 'Ivan';
      $Ivan->email = 'ivan@ya.ru';
      $Ivan->password = Hash::make('pass');
      $Ivan->save();
      $Ivan->roles()->attach($manager);

      $Zoya = new User();
      $Zoya->name = 'Zoya';
      $Zoya->email = 'zoya@ya.ru';
      $Zoya->password = Hash::make('pass');
      $Zoya->save();
      $Zoya->roles()->attach($leader);
      $Zoya->permissions()->attach($can_edit_vacation);

      $Andrey = new User();
      $Andrey->name = 'Andrey';
      $Andrey->email = 'andrey@ya.ru';
      $Andrey->password = Hash::make('pass');
      $Andrey->save();
      $Andrey->roles()->attach($admin);
      $Andrey->permissions()->attach($can_edit_vacation);
    }
}
