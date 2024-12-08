<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

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

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
