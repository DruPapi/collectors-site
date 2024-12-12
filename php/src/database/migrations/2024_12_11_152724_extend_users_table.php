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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
            $table->smallInteger('zip')->nullable()->after('email');
            $table->string('city')->nullable()->after('zip');
            $table->string('address')->nullable()->after('city');
            $table->string('phone')->nullable()->after('address');
            $table->string('own_site_address')->nullable()->after('phone');
            $table->boolean('site_is_public')->default(false)->after('own_site_address');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'zip',
                'city',
                'address',
                'phone',
                'own_site_address',
                'site_is_public',
            ]);
        });
    }
};
