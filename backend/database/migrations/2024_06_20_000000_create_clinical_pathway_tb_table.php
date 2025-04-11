<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clinical_pathway_tb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->json('screening')->comment('Data skrining TB');
            $table->json('diagnosis')->comment('Data diagnosis TB');
            $table->json('therapy')->comment('Data terapi TB');
            $table->json('monitoring')->comment('Data monitoring terapi');
            $table->json('follow_up')->comment('Data tindak lanjut');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clinical_pathway_tb');
    }
};
