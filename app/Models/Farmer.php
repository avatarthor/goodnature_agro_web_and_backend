<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Farmer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function farmerLoans()
    {
        return $this->hasMany(FarmerLoan::class);
    }

    public function farmerInputs()
    {
        return $this->hasMany(FarmerInput::class);
    }
}
