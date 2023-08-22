<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnScheduledRepayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scheduled_repayments', function (Blueprint $table) {
            //
            $table->integer('amount');
            $table->integer('outstanding_amount');
            $table->string('currency_code');
            $table->string('due_date');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scheduled_repayments', function (Blueprint $table) {
            //
            $table->integer('amount');
            $table->integer('outstanding_amount');
            $table->string('currency_code');
            $table->string('due_date');
        });
    }
}
