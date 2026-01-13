<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Link to Users table
            $table->string('name')->default('Untitled Flow');
            $table->longText('flow_data')->nullable(); // JSON structure for the flow
            $table->boolean('status')->default(1);
            $table->timestamps();

            // Optional: Foreign key constraint if you want strict integrity
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flows');
    }
};
