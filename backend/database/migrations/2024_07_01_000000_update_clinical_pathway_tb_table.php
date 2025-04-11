<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clinical_pathway_tb', function (Blueprint $table) {
            $table->string('cp_number')->after('id');
            $table->date('effective_date')->after('cp_number');
            $table->string('patient_name')->after('effective_date');
            $table->string('medical_record_number')->after('patient_name');
            $table->date('birth_date')->after('medical_record_number');
            $table->string('special_notes')->nullable()->after('birth_date');
            $table->json('clinical_services')->after('special_notes');
            $table->json('fluid_guidelines')->nullable()->after('clinical_services');
            $table->string('patient_criteria')->nullable()->after('fluid_guidelines');
            
            $table->dropColumn(['patient_id', 'screening_data', 'diagnosis_data', 
                              'therapy_data', 'monitoring_data', 'follow_up_data']);
        });
    }

    public function down()
    {
        Schema::table('clinical_pathway_tb', function (Blueprint $table) {
            $table->dropColumn(['cp_number', 'effective_date', 'patient_name',
                              'medical_record_number', 'birth_date', 'clinical_services']);
            
            $table->foreignId('patient_id')->constrained();
            $table->json('screening_data');
            $table->json('diagnosis_data');
            $table->json('therapy_data');
            $table->json('monitoring_data');
            $table->json('follow_up_data');
        });
    }
};
