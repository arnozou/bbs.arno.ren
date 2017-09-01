<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('topic_id')->unsigned()->comment('主题ID');
            $table->integer('user_id')->unsigned();
            $table->integer('vote_count')->default(0);
            $table->text('body');
            $table->text('body_original');
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
        Schema::dropIfExists('replies');
    }
}
