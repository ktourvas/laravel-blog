<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_articles', function (Blueprint $table) {

            $table->increments('id');

//            $table->string('id')->unique();

            $table->unsignedInteger('user_id')->nullable();

            $table->string('slug', 255)->unique();

            $table->timestamps();

//            $table->string('title', 255)->nullable();
//            $table->string('subtitle', 255)->nullable();
//            $table->string('body', 255)->nullable();
//            $table->string('ip_address', 45)->nullable();
//            $table->string('ip_address', 45)->nullable();
//            $table->text('user_agent')->nullable();
//            $table->text('payload');
//            $table->integer('last_activity');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lb_articles');
    }
}
