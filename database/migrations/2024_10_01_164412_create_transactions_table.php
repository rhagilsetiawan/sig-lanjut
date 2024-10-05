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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // 'id' column with auto-increment
            $table->char('prod_id', 13); // 'prod_id' column (char with length 13)
            $table->unsignedBigInteger('shop_id'); // 'shop_id' column (foreign key to shops)
            $table->integer('price')->nullable(); // 'price' column (nullable)
            $table->unsignedBigInteger('user_id'); // 'user_id' column (foreign key to users)
            $table->timestamps(); // 'created_at' and 'updated_at' columns

            // Indexes
            $table->index('user_id');
            $table->index('prod_id');
            $table->index('shop_id');

            // Foreign Key Constraints
            $table->foreign('prod_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
