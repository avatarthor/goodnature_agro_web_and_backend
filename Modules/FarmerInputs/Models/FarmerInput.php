<?php

namespace Modules\FarmerInputs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Farmer;


class FarmerInput extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function inputType()
    {
        return $this->belongsTo(InputType::class);
    }
}
