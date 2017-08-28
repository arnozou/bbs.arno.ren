<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authcodes', function(Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->char('mobile', 20)->comment('手机号');
            $table->Integer('code')->comment('验证码');
            $table->unsignedInteger('ip')->comment('IP');
            $table->boolean('is_used')->default(0)->comment('是否使用');
            $table->timestamp('expire_at')->nullable()->comment('过期时间');
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
        Schema::dropIfExists('authcodes');
    }
}
