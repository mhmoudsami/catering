<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('status')->default(1);

            $table->date('date');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('location');
            $table->text('notes')->nullable();
            $table->integer('persons_count');
            $table->string('address')->nullable();

            $table->integer('service_capacity');
            $table->decimal('service_price', 9, 2);
            $table->decimal('service_extra_person_price', 9, 2);

            // website percentage
            $table->integer('percentage_number')->default(10);
            $table->decimal('percentage_amount', 9, 2);

            $table->decimal('subtotal', 9, 2);
            $table->decimal('taxes', 9, 2)->default(0);
            $table->decimal('total', 9, 2);

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('service_id')->on('services')->references('id');
            $table->foreign('provider_id')->on('providers')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('city_id')->on('cities')->references('id');
        });

        Schema::create('order_notes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('status')->default(1);
            $table->text('note');
            

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('order_id')->on('orders')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_notes');
        Schema::dropIfExists('orders');
    }
}
