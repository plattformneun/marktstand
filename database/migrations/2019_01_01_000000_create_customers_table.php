<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('verified_at')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_form')->nullable();
            $table->string('street')->nullable();
            $table->string('house', 16)->nullable();
            $table->string('post_code', 8)->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('vat_id')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
