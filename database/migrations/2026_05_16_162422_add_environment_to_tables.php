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
            $table->foreignId('pos_environment_id')->nullable()->constrained('pos_environments')->onDelete('set null');
            $table->timestamp('last_login_at')->nullable();
            $table->decimal('total_hours_logged', 8, 2)->default(0);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('pos_environment_id')->nullable()->constrained('pos_environments')->onDelete('cascade');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('pos_environment_id')->nullable()->constrained('pos_environments')->onDelete('cascade');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('pos_environment_id')->nullable()->constrained('pos_environments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
