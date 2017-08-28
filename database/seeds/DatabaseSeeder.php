<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
  protected $toTruncate = [
  'users', 'user_infos', 'authcodes', 'categories'
  ];
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //关闭外键检查

    foreach ($this->toTruncate as $table) {
      DB::table($table)->truncate();
    }

    $this->call(UserTableSeeder::class);
    $this->call(CategoryTableSeeder::class);

    $this->command->info('>>>数据已经成功填充到数据库中<<<');
    DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //开启外键检查

    Model::reguard();
  }
}
