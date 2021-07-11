<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained();
            $table->unsignedTinyInteger('month')->default(1);
            $table->year('year');
            $table->integer('payments_generated')->default(0);
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
        Schema::dropIfExists('plan_logs');
    }
}
