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
            // Define the 'id' as char(13) with NOT NULL and default ''
            $table->char('id', 13)->default('')->primary();
            
            // Define 'name' as varchar(50) and NOT NULL
            $table->string('name', 50);
            
            // Define 'category' as varchar(20) with utf8mb3 and default 'lainnya'
            $table->string('category', 20)->default('lainnya');
            
            // Add created_at and updated_at columns
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
