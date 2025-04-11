<?php

namespace App\Http\Controllers;

use App\Models\ClinicalPathwayTb;
use App\Exports\ClinicalPathwayExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClinicalPathwayController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cp_number' => 'required|string',
            'effective_date' => 'required|date',
            'patient_name' => 'required|string',
            'medical_record_number' => 'required|string',
            'birth_date' => 'required|date',
            'doctor_in_charge' => 'required|string',
            'diagnosis_date' => 'required|date',
            'special_notes' => 'nullable|string',
            'clinical_services' => 'required|array',
            'tb_type' => 'required|in:pulmonary,extrapulmonary,mdr',
            'sputum_test' => 'required|in:positive,negative,pending',
            'hiv_status' => 'nullable|boolean',
            'drug_resistance' => 'nullable|in:sensitive,mono,poly,mdr,xdr',
            'treatment_phase' => 'required|string',
            'treatment_week' => 'required|integer|min:1|max:24'
        ]);

        $pathway = ClinicalPathwayTb::create($validated);

        return response()->json($pathway, 201);
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'cp_number' => 'required|string',
            'effective_date' => 'required|date',
            'patient_name' => 'required|string',
            'medical_record_number' => 'required|string',
            'birth_date' => 'required|date',
            'doctor_in_charge' => 'required|string',
            'diagnosis_date' => 'required|date',
            'special_notes' => 'nullable|string',
            'clinical_services' => 'required|array',
            'tb_type' => 'required|in:pulmonary,extrapulmonary,mdr',
            'sputum_test' => 'required|in:positive,negative,pending',
            'hiv_status' => 'nullable|boolean',
            'drug_resistance' => 'nullable|in:sensitive,mono,poly,mdr,xdr',
            'treatment_phase' => 'required|string',
            'treatment_week' => 'required|integer|min:1|max:24'
        ]);
        
        return Excel::download(new ClinicalPathwayExport($validated), 'clinical_pathway_tb.xlsx');
    }
}
