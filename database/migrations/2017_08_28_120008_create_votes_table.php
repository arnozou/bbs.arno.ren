<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigend();
            $table->integer('votable_id')->unsigned();
            $table->boolean('vote_type')->default(1)->comment('1赞0踩');
            $table->enum('votable_type', ['topic', 'reply'])->comment('vote对应表');
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
        Schema::dropIfExists('votes');
    }
}
