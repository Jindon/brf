<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('patron_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained();
            $table->integer('amount');
            $table->integer('fine')->default(0);
            $table->integer('total');
            $table->integer('paid')->default(0);
            $table->integer('due');
            $table->date('due_date');
            $table->unsignedTinyInteger('month')->default(1);
            $table->year('year');
            $table->date('paid_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
