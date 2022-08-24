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
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            $table->string('preview_image')->nullable();
            $table->string('full_image')->nullable();
            $table->string('original_image')->nullable();

            $table->unsignedBigInteger('product_id');
            $table->index('product_id', 'image_product_idx');
            $table->foreign('product_id', 'image_product_fk')->on('products')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('images');
    }
};
