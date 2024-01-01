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
        Schema::table('item_cateogry', function (Blueprint $table) {
            $table->dropForeign('item_cateogry_item_id_foreign');
            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade');

            $table->dropForeign('item_cateogry_category_id_foreign');
            $table->foreign('category_id')->references('id')->on('category')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
