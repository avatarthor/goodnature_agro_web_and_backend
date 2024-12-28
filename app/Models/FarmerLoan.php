<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FarmerLoan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }
}
