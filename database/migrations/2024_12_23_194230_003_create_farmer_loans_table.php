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
        Schema::create('farmer_loans', function (Blueprint $table) {
            $table->id();
            $table->double('loan_amount');
            $table->double('interest_rate');
            $table->integer('repayment_duration');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->integer('repaid')->default(0);
            $table->bigInteger('farmer_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table
                ->foreign('farmer_id')
                ->references('id')
                ->on('farmers')
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
        Schema::dropIfExists('farmer_loans');
    }
};
