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
        'barangay_business_clearance',
        'cedula',
        'contract_of_lease',
        'locational_clearance',
        'sanitary_permit',
        'fire_safety_inspection_permit',
    ];
}
