<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_no');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('client_pledge_cleared');
            $table->date('deposit_date')->nullable();
            $table->unsignedTinyInteger('contribution_progress')->nullable();
            $table->timestamps();

            $table->index('client_id');
            // Add foreign key constraints if needed
            // $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributions');
    }
}