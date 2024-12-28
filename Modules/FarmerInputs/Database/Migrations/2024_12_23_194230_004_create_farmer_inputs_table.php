<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmer_inputs_module', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farmer_id'); // Match the type of farmers.id
            $table->unsignedBigInteger('input_type_id'); // Match the type of input_types.id
            $table->integer('quantity');
            $table->date('distributed_date');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table
                ->foreign('farmer_id')
                ->references('id')
                ->on('farmers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('input_type_id')
                ->references('id')
                ->on('input_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farmer_inputs_module');
    }
};
