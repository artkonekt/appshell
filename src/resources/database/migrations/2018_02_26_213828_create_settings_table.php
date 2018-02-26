<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 512);
            $table->integer('user_id')->unsigned()->nullable();
            $table->text('value');
            $table->timestamps();

            $table->unique(['key', 'user_id']);
            $table->index('key');
        });
    }

    public function down()
    {
        Schema::drop('settings');
    }
}
