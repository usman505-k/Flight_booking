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
        Schema::table('flights', function (Blueprint $table) {
            // add status column default 'active'
            $table->string('status')->default('active')->after('seats');
        });
    }

    /**
     * Reverse the migrations.
     */
       public function down(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
