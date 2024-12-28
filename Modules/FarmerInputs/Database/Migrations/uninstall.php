<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UninstallModuleFarmerLoans
{
    public function down()
    {
        Schema::dropIfExists('farmer_inputs_module');
        Schema::dropIfExists('input_types_module');

    }
}
