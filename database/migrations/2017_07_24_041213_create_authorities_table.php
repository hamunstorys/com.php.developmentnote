<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthoritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();

            $table->boolean('articles_creatable')->nullable();
            $table->boolean('articles_updatable')->nullable();
            $table->boolean('articles_readable')->nullable();
            $table->boolean('articles_deletable')->nullable();

            $table->boolean('comments_creatable')->nullable();
            $table->boolean('comments_updatable')->nullable();
            $table->boolean('comments_readable')->nullable();
            $table->boolean('comments_deletable')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authorities', function (Blueprint $table) {
            $table->dropColumn('authorities_user_id_foreign');
        });

        Schema::dropIfExists('authorities');
    }
}
