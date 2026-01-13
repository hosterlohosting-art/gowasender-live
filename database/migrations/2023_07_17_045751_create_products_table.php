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
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('inventory_id')->unsigned()->index();
        $table->foreign('inventory_id')->references('id')->on('inventory')->onDelete('cascade');
        $table->string('name');
        $table->decimal('price', 8, 2);
        $table->integer('quantity')->default(0);
        $table->boolean('status')->default(true);
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
};

