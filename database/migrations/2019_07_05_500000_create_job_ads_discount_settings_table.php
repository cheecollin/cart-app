<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobAdsDiscountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_ads_discount_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id');
            $table->bigInteger('job_ad_id');
            $table->bigInteger('discount_id');
            $table->integer('discount_value')->nullable();
            $table->decimal('discounted_price', 9, 2);
            
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('job_ad_id')->references('id')->on('job_ads');
            $table->foreign('discount_id')->references('id')->on('job_ads_discount_types');
            
            $table->index(['customer_id', 'job_ad_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_ads_discount_settings');
    }
}
