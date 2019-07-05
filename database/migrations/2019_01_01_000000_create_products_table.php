<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->bigInteger('producer_id');
            $table->boolean('visibillity')->default(false);
            $table->string('title', 32);
            $table->text('description')->nullable();
            $table->string('characteristic', 128)->nullable();
            $table->string('article_number')->nullable();
            $table->bigInteger('image_id')->nullable();
            $table->string('unit', 12);
            $table->smallInteger('volume')->unsigned();
            $table->string('volume_unit', 12);
            $table->integer('price')->unsigned();
            $table->string('price_unit', 12);
            $table->tinyInteger('vat')->unsigned();
            $table->string('packaging', 32)->nullable();
            $table->text('ingredients')->nullable();
            $table->string('expiration', 32)->nullable();
            $table->smallInteger('lead_time')->nullable();
            $table->integer('deposit')->unsigned()->nullable();
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
        Schema::dropIfExists('products');
    }
}
