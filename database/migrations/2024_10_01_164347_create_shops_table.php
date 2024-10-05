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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();  // id dengan auto-increment
            $table->string('name', 50)->nullable();  // Kolom name varchar(50) yang boleh null
            $table->string('address', 50)->nullable();  // Kolom address varchar(50) yang boleh null
            $table->double('lat')->nullable();  // Kolom latitude double yang boleh null
            $table->double('lng')->nullable();  // Kolom longitude double yang boleh null
            $table->timestamps();  // timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
};
