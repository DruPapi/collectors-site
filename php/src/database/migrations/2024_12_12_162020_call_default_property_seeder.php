<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('db:seed', ['--class' => DefaultPropertySeeder::class]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
