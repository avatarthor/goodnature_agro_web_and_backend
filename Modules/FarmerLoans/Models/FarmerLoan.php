<?php

namespace Modules\FarmerLoans\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Farmer;

class FarmerLoan extends Model
{
    use HasFactory;



    protected $guarded = [];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }
}
