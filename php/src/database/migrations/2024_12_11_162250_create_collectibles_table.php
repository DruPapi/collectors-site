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
        Schema::create('collectibles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_name')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories', 'id');
            $table->foreignId('item_type_id')->nullable()->constrained('item_types', 'id');
            $table->boolean('is_public')->default(false);
            $table->smallInteger('value')->default(1);
            $table->smallInteger('quantity')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collectibles');
    }
};
