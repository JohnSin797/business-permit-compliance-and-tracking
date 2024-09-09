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
        'valid_until',
    ];

    public function permitRequest()
    {
        return $this->hasMany(BusinessPermitRequest::class, 'business_id', 'id');
    }
}
