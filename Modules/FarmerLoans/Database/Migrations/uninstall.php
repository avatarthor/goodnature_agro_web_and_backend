<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UninstallModuleFarmerLoans
{
    public function down()
    {
        Schema::dropIfExists('farmer_loans_module');
    }
}
