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
            $table->string('barangay_clearance')->nullable();
            $table->string('tin')->nullable();
            $table->string('business_registration')->nullable();
            $table->string('bir_certificate_of_registration')->nullable();
            $table->string('notarized_contract_of_lease')->nullable();
            $table->string('ecc_cnc_denr')->nullable();
            if (Schema::hasColumn('permit_requirements', 'application_form')) {
                $table->dropColumn('application_form');
            }
            if (Schema::hasColumn('permit_requirements', 'certificate_of_registration')) {
                $table->dropColumn('certificate_of_registration');
            }
            if (Schema::hasColumn('permit_requirements', 'barangay_business_clearance')) {
                $table->dropColumn('barangay_business_clearance');      
            }
            if (Schema::hasColumn('permit_requirements', 'contract_of_lease')) {
                $table->dropColumn('contract_of_lease');      
            }
            if (Schema::hasColumn('permit_requirements', 'locational_clearance')) {
                $table->dropColumn('locational_clearance');      
            }
            if (Schema::hasColumn('permit_requirements', 'sanitary_permit')) {
                $table->dropColumn('sanitary_permit');      
            }
            if (Schema::hasColumn('permit_requirements', 'fire_safety_inspection_permit')) {
                $table->dropColumn('fire_safety_inspection_permit');      
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permit_requirements', function (Blueprint $table) {
            //
        });
    }
};
