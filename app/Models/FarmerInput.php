<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
