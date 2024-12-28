<?php

namespace Modules\FarmerInputs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InputType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function farmerInputs()
    {
        return $this->hasMany(FarmerInput::class);
    }
}
