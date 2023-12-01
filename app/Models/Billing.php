<?php

namespace App\Models;

use App\Models\Upazila;
use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];

    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }
    public function upazila()
    {
        return $this->hasOne(Upazila::class, 'id', 'upazila_id');
    }
}
