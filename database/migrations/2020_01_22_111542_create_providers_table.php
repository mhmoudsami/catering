<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->json('description')->nullable();

            $table->text('responsible_name');
            $table->text('responsible_email')->nullable();
            $table->text('responsible_mobile')->nullable();

            $table->boolean('status')->default(true);
            $table->integer('order')->default(0);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('providers');
    }
}
