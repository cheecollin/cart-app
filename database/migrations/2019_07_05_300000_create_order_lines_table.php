<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->bigInteger('job_ad_id');
            $table->integer('quantity');
            $table->decimal('price', 9, 2);
            $table->decimal('discount', 9, 2);
            
            $table->timestamps();
            
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('job_ad_id')->references('id')->on('job_ads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_lines');
    }
}
