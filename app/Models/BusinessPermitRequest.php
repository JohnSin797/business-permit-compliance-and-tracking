<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessPermitRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_id',
        'request_type',
        'status',
    ];

    public function requirements()
    {
        return $this->hasOne(PermitRequirement::class, 'request_id', 'id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }
}
