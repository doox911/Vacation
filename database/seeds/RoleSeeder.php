<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $manager = new Role();
    $manager->name = 'Manager';
    $manager->slug = 'manager';
    $manager->save();

    $leader = new Role();
    $leader->name = 'Leader';
    $leader->slug = 'leader';
    $leader->save();

    $admin = new Role();
    $admin->name = 'Admin';
    $admin->slug = 'admin';
    $admin->save();
  }
}
