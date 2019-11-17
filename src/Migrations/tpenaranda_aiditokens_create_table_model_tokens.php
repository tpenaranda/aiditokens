<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModelTokens extends Migration
{
    public function up()
    {
        Schema::create('tpenaranda_aiditokens_model_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->index()->unique();
            $table->string('model_class');
            $table->unsignedInteger('model_id')->index();
            $table->dateTime('expire_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tpenaranda_aiditokens_model_tokens');
    }
}
