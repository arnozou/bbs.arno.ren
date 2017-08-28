<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CategoryTableSeeder extends Seeder {
  protected $datas = [
    ['新闻区', 0, '新资讯~', 'glyphicon-modal-window', '#fff' ,'#A1B56C'],
    ['资源区', 0, '各类资源', 'glyphicon-save', '#fff' ,'#A1B56C'],
    ['3DS游戏', 2, '3DS游戏下载', 'glyphicon-save', '#fff', '#A1B56C']
  ];
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    foreach ($this->datas as $value) {
      $datas[] = [
        'title'         => $value[0],
        'parent_id'     => $value[1],
        'description'   => $value[2],
        'icon'          => $value[3],
        'color'         => $value[4],
        'bg_color'      => $value[5],
        'created_at'    => Carbon::now()->toDateTimeString(),
        'updated_at'    => Carbon::now()->toDateTimeString(),
      ];
    }

    DB::table('categories')->insert($datas);
  }
}
