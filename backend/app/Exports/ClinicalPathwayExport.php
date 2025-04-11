<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClinicalPathwayExport implements FromArray, WithMultipleSheets, WithHeadings, WithStyles
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data['clinical_services'];
    }

    public function headings(): array
    {
        return [
            'Komponen',
            'Konten',
            'Minggu 1',
            'Minggu 2',
            'Minggu 3',
            'Minggu 4'
        ];
    }

    public function sheets(): array
    {
        return [
            'Data Pasien' => new PatientDataSheet($this->data),
            'Pelayanan Klinis' => $this,
            'Panduan Klinis' => new ClinicalGuidelinesSheet()
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:E' => ['alignment' => ['wrapText' => true]]
        ];
    }
}

class PatientDataSheet implements FromArray, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return [
            ['No. CP', $this->data['cp_number']],
            ['Tanggal Berlaku', $this->data['effective_date']],
            ['Nama Pasien', $this->data['patient_name']],
            ['No. RM', $this->data['medical_record_number']],
            ['Tanggal Lahir', $this->data['birth_date']],
            ['Dokter Penanggungjawab', $this->data['doctor_in_charge']],
            ['Tanggal Diagnosis', $this->data['diagnosis_date']],
            ['Tipe TB', $this->data['tb_type']],
            ['Hasil Tes Dahak', $this->data['sputum_test']],
            ['Status HIV', $this->data['hiv_status'] ? 'Positif' : 'Negatif'],
            ['Resistensi Obat', $this->data['drug_resistance'] ?? 'Sensitif'],
            ['Fase Pengobatan', $this->data['treatment_phase']],
            ['Minggu Pengobatan', $this->data['treatment_week']],
            ['Catatan Khusus', $this->data['special_notes'] ?? '']
        ];
    }

    public function title(): string
    {
        return 'Data Pasien';
    }
}

class ClinicalGuidelinesSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $guidelines = [
            ['Regimen Pengobatan'],
            ['Fase Intensif: 2HRZE'],
            ['Fase Lanjutan: 4HR'],
            ['MDR-TB: 6-9 bulan kanamisin, levofloxacin, dll'],
            [],
            ['Pemantauan Efek Samping'],
            ['- Hepatotoksisitas (bulan 1-2)'],
            ['- Neuropati (bulan 3-6)'],
            ['- Gangguan penglihatan (etambutol)'],
            [],
            ['Kriteria Pasien TB'],
            [$this->data['patient_criteria'] ?? 'Pasien TB baru tanpa komplikasi']
        ];

        return $guidelines;
    }

    public function title(): string
    {
        return 'Panduan Klinis';
    }
}
