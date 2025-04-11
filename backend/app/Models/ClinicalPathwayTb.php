<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalPathwayTb extends Model
{
    use HasFactory;

    protected $fillable = [
        'cp_number',
        'effective_date',
        'patient_name',
        'medical_record_number',
        'birth_date',
        'special_notes',
        'clinical_services',
        'fluid_guidelines',
        'patient_criteria',
        'tb_type',
        'sputum_test',
        'hiv_status',
        'drug_resistance',
        'treatment_phase',
        'treatment_week'
    ];

    protected $casts = [
        'effective_date' => 'date',
        'birth_date' => 'date',
        'clinical_services' => 'array',
        'fluid_guidelines' => 'array'
    ];
}
