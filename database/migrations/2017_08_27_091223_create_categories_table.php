<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table) {
            $table->Increments('id')->comment('板块id');
            $table->unsignedInteger('parent_id')->comment('父级id');
            $table->string('title', 30)->comment('板块标题');
            $table->string('description', 255)->comment('描述');
            $table->string('icon', 100)->comment('图标class');
            $table->string('color', 30)->comment('图标颜色');
            $table->string('bg_color', 30)->comment('图标背景颜色');
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
        Schema::dropIfExists('categories');
    }
}
