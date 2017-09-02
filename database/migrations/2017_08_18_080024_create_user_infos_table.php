<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_infos', function(Blueprint $table) {
      $table->Integer('user_id')->unsigned()->comment('用户ID');
      $table->string('real_name', 32)->default('')->comment('用户真实姓名');
      $table->string('nick_name', 32)->default('')->comment('称昵');
      $table->string('avatar_url')->comment('头像地址');
      $table->TinyInteger('gender')->unsigned()->default(1)->comment('性别');
      $table->TinyInteger('age')->unsigned()->default(0)->comment('年龄');
      $table->date('birthday')->nullable()->comment('出生日期');
      $table->string('qq', 20)->default('')->comment('QQ号');
      $table->string('wechat', 80)->default('')->comment('微信号');
      $table->string('intro', 255)->default('')->comment('简介');
      $table->timestamps();
      $table->primary('user_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_infos');
  }
}
