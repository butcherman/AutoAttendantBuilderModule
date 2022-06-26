<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class CreateCallFlowDataTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('call_flow_data', function (Blueprint $table) {
            $table->id();
            $table->uuid('aa_link'); // ->default(Str::uuid());
            $table->longText('aa_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('call_flow_data');
    }
}
