<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\FarmerLoans\Models\FarmerLoan;
use Modules\FarmerInputs\Models\FarmerInput;


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
