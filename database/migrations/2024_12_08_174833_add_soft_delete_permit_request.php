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
        Schema::table('business_permit_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('business_permit_requests', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_permit_requests', function (Blueprint $table) {
            if (Schema::hasColumn('business_permit_requests', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
