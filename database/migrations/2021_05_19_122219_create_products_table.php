<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
            $table->unsignedBigInteger('status_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('thumbnail_url')->default(
                Storage::url('product-images/default.png')
            );
            $table->unsignedFloat('price');
            $table->unsignedInteger('available_count');
            $table->timestamp('last_status_change')->default(now());
            $table->timestamps();

            $table->foreign('status_id')
                ->references('id')
                ->on('product_statuses');
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
