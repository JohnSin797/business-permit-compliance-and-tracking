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
        Schema::table('permit_requirements', function (Blueprint $table) {
            $table->dropColumn('sec_dti_cda_registration');
            $table->string('application_form')->nullable();
            $table->string('certificate_of_registration')->nullable();
            $table->string('barangay_business_clearance')->nullable();
            $table->string('cedula')->nullable();
            $table->string('contract_of_lease')->nullable();
            $table->string('locational_clearance')->nullable();
            $table->string('sanitary_permit')->nullable();
            $table->string('fire_safety_inspection_permit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permit_requirements', function (Blueprint $table) {
            $table->string('sec_dti_cda_registration')->nullable();
        });
    }
};
