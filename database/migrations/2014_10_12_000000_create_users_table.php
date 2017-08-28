<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('用户ID');
            // $table->string('mobile', 30)->unique()->comment('用户手机号');
            $table->char('mobile', 20)->default('')->comment('用户手机号');
            // $table->string('email', 100)->unique()->comment('用户邮箱');
            $table->string('email', 100)->default('')->comment('用户邮箱');
            $table->string('password', 100)->nullable()->comment('密码');
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
        Schema::dropIfExists('users');
    }
}
