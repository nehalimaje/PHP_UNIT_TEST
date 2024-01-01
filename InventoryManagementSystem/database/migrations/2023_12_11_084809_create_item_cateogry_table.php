<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_cateogry', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('item_cateogry', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('category_id')->references('id')->on('category');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_cateogry');
    }
};
