<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->double('pourcentage');
            $table->boolean('is_promo')->default('true');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade');
            $table->unsignedInteger('promotion_id');
            $table->foreign('promotion_id')->references('id')->on('promotions')
                ->onDelete('cascade');
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
        Schema::dropIfExists('product_promotions');
    }
}
