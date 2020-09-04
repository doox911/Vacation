<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $createTasks = new Permission();
    $createTasks->name = 'Can edit vacation';
    $createTasks->slug = 'can_edit_vacation';
    $createTasks->save();
  }
}
