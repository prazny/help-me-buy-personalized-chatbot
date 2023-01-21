<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_sources', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('client_id', 400);
            $table->string('client_secret', 400);
            $table->string('refresh_token', 400);
            $table->string('access_token', 400);
            $table->integer('expires_at');
            $table->boolean('is_parsed')->default(0);
            $table->boolean('is_correct')->default(0);
            $table->json('errors')->nullable();
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
        Schema::dropIfExists('oauth_sources');
    }
};
