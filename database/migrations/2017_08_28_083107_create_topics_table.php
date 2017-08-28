<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function(Blueprint $table) {
            $table->increments('id')->comment('主题帖ID');
            $table->integer('category_id')->comment('板块ID');
            $table->string('title', 200)->comment('主题标题');
            $table->text('body');
            $table->integer('user_id')->comment('用户ID');
            $table->integer('reply_count')->unsigned()->default(0);
            $table->integer('vote_count')->default(0);
            $table->integer('read_count')->unsigned()->default(0);
            $table->integer('last_reply_user_id')->unsigned()->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('topics');
    }
}
