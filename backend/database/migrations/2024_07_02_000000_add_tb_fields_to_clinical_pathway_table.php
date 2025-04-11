<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clinical_pathway_tb', function (Blueprint $table) {
            $table->enum('tb_type', ['pulmonary', 'extrapulmonary', 'mdr'])->after('patient_criteria');
            $table->enum('sputum_test', ['positive', 'negative', 'pending'])->after('tb_type');
            $table->boolean('hiv_status')->nullable()->after('sputum_test');
            $table->enum('drug_resistance', ['sensitive', 'mono', 'poly', 'mdr', 'xdr'])->nullable()->after('hiv_status');
            $table->string('treatment_phase')->after('drug_resistance');
            $table->integer('treatment_week')->after('treatment_phase');
        });
    }

    public function down()
    {
        Schema::table('clinical_pathway_tb', function (Blueprint $table) {
            $table->dropColumn([
                'tb_type',
                'sputum_test', 
                'hiv_status',
                'drug_resistance',
                'treatment_phase',
                'treatment_week'
            ]);
        });
    }
};
