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
        Schema::create('user_login_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('access_token', 200)->index();
            $table->string('refresh_token', 200)->index();
            $table->bigInteger('user_id')->index();
            $table->boolean('revoked')->default(0)->index();
            $table->timestamp('expired_at')->index();
            $table->timestamp('refresh_token_expired_at')->index();
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
        Schema::dropIfExists('user_login_accesses');
    }
};
