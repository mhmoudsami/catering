<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('provider_id');

            $table->json('name');
            $table->json('description')->nullable();
            $table->text('video_url')->nullable();

            $table->decimal('price', 9, 2);
            $table->decimal('extra_person_cost', 9, 2);
            $table->integer('capacity');

            $table->text('duration')->nullable();
            $table->text('prepare_time')->nullable();

            $table->text('gender')->nullable();

            $table->boolean('status')->default(true);
            $table->integer('order')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
