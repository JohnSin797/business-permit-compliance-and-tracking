<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_address',
        'date_established',
        'type_of_organization',
        'dti_registration_number',
        'tin',
    ];

    public function permitRequest()
    {
        return $this->hasMany(BusinessPermitRequest::class, 'business_id', 'id');
    }
}
