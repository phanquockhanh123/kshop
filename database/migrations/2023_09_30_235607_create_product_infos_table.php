<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('color_id');
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->double('price_more');
            $table->integer('quantity');
            $table->integer('quantity_avail')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // foreign key
            $table->foreign('product_id', 'FK_products_infos_1')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('size_id', 'FK_products_infos_2')
                ->references('id')
                ->on('sizes')
                ->onDelete('cascade');

            $table->foreign('color_id', 'FK_products_infos_3')
                ->references('id')
                ->on('colors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_infos');
    }
}
