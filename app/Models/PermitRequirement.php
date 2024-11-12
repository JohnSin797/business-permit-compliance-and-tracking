<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'application_form',
        'certificate_of_registration',
        'barangay_clearance',
        'cedula',
        'locational_clearance',
        'sanitary_permit',
        'fire_safety_inspection_permit',
        'tin',
        'business_registration',
        'bir_certificate_of_registration',
        'notarized_contract_of_lease',
        'ecc_cnc_denr',
    ];
}
