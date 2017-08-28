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
            $table->increment('id');
            $table->integer('user_id')->unsigend();
            $table->integer('votable_id')->unsigned();
            $table->boolean('vote_type')->comment('1赞0踩');
            $table->enum('vatable_type', ['topic', 'reply'])->comment('vote对应表');
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
        //
    }
}
