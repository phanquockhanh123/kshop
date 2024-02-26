<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->string('name')->unique();
            $table->string('supplier');
            $table->string('tags');
            $table->double('price');
            $table->double('price_compare');
            $table->boolean('is_ship')->default(true);
            $table->float('weight');
            $table->text('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('priority')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // foreign key
            $table->foreign('category_id', 'FK_products_1')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->foreign('discount_id', 'FK_products_2')
                ->references('id')
                ->on('discounts')
                ->onDelete('cascade');

            $table->foreign('campaign_id', 'FK_products_3')
                ->references('id')
                ->on('campaigns')
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
        Schema::dropIfExists('products');
    }
}
