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
      $table->unsignedInteger('user_id')->primary()->comment('用户ID');
      $table->string('real_name', 32)->default('')->comment('用户真实姓名');
      $table->string('nick_name', 32)->comment('称昵');
      $table->string('avatar_url')->comment('头像地址');
      $table->unsignedTinyInteger('gender')->default(0)->comment('性别');
      $table->unsignedTinyInteger('age')->default(0)->comment('年龄');
      $table->date('birthday')->nullable()->comment('出生日期');
      $table->string('qq', 20)->default('')->comment('QQ号');
      $table->string('wechat', 80)->default('')->comment('微信号');
      $table->string('intro', 255)->default('')->comment('简介');
      $table->timestamps();
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
