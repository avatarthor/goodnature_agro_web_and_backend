<?php

namespace Modules\FarmerInputs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Farmer;
use Modules\FarmerInputs\Models\InputType; // Import the InputType model


class FarmerInput extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'farmer_inputs_module';

    protected $fillable = [
        'farmer_id',
        'input_type_id',
        'quantity',
        'distributed_date',
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function inputType()
    {
        return $this->belongsTo(InputType::class);
    }
}
