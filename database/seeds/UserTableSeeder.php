<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder {
  protected $datas = [
    ['arnozou@126.com', '邹家鑫', '13424463876', 'arno', 'http://blog.qiji.tech/wp-content/uploads/2016/07/test.jpg', '1', '简介']
  ];
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    foreach ($this->datas as $key => $value) {
      factory(App\User::class)->create([
        'mobile'    => $value[2],
        'email'     => $value[0],
        'password'  => Hash::make('1234'),
      ]);

      factory(App\UserInfo::class)->create([
        'user_id'     => $key + 1,
        'real_name'   => $value[1],
        'nick_name'   => $value[3],
        'avatar_url'  => $value[4],
        'gender'      => $value[5],
        'intro'       => $value[6],
        ]);
    }
  }
}
