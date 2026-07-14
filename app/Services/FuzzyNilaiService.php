<?php

namespace App\Services;

class FuzzyNilaiService
{
    protected FuzzyLogicService $fuzzy;

    public function __construct()
    {
        $this->fuzzy = new FuzzyLogicService();
        $this->setup();
    }

    protected function setup(): void
    {
        $this->fuzzy->addMembershipFunction('tugas', 'Rendah', [0, 0, 40], 'triangular');
        $this->fuzzy->addMembershipFunction('tugas', 'Sedang', [30, 50, 70], 'triangular');
        $this->fuzzy->addMembershipFunction('tugas', 'Tinggi', [60, 100, 100], 'triangular');

        $this->fuzzy->addMembershipFunction('uts', 'Rendah', [0, 0, 40], 'triangular');
        $this->fuzzy->addMembershipFunction('uts', 'Sedang', [30, 50, 70], 'triangular');
        $this->fuzzy->addMembershipFunction('uts', 'Tinggi', [60, 100, 100], 'triangular');

        $this->fuzzy->addMembershipFunction('uas', 'Rendah', [0, 0, 40], 'triangular');
        $this->fuzzy->addMembershipFunction('uas', 'Sedang', [30, 50, 70], 'triangular');
        $this->fuzzy->addMembershipFunction('uas', 'Tinggi', [60, 100, 100], 'triangular');

        $this->fuzzy->addMembershipFunction('nilai_akhir', 'Rendah', [0, 0, 45], 'triangular');
        $this->fuzzy->addMembershipFunction('nilai_akhir', 'Sedang', [30, 55, 80], 'triangular');
        $this->fuzzy->addMembershipFunction('nilai_akhir', 'Tinggi', [60, 100, 100], 'triangular');

        $this->fuzzy->setOutputRange('nilai_akhir', 0, 100);

        $labels = ['Rendah', 'Sedang', 'Tinggi'];
        foreach ($labels as $t) {
            foreach ($labels as $u) {
                foreach ($labels as $ua) {
                    $nilai = match (true) {
                        $t === 'Tinggi' && $u === 'Tinggi' && $ua === 'Tinggi' => 'Tinggi',
                        $t === 'Rendah' && $u === 'Rendah' && $ua === 'Rendah' => 'Rendah',
                        $t === 'Tinggi' || $u === 'Tinggi' || $ua === 'Tinggi' => 'Tinggi',
                        $t === 'Rendah' || $u === 'Rendah' || $ua === 'Rendah' => 'Rendah',
                        default => 'Sedang',
                    };
                    $this->fuzzy->addRule(
                        [
                            ['variable' => 'tugas', 'label' => $t],
                            ['variable' => 'uts', 'label' => $u],
                            ['variable' => 'uas', 'label' => $ua],
                        ],
                        'nilai_akhir',
                        $nilai
                    );
                }
            }
        }
    }

    public function hitung(?float $tugas, ?float $uts, ?float $uas): array
    {
        $tugas = $tugas ?? 0;
        $uts = $uts ?? 0;
        $uas = $uas ?? 0;

        $memberships = [
            'tugas' => $this->fuzzy->fuzzify('tugas', $tugas),
            'uts' => $this->fuzzy->fuzzify('uts', $uts),
            'uas' => $this->fuzzy->fuzzify('uas', $uas),
        ];

        $aggregated = $this->fuzzy->evaluateRules($memberships);
        $nilaiAkhir = $this->fuzzy->defuzzify('nilai_akhir', $aggregated);
        $nilaiHuruf = $this->fuzzy->nilaiToHuruf($nilaiAkhir);

        return [
            'nilai_akhir' => $nilaiAkhir,
            'nilai_huruf' => $nilaiHuruf,
            'fuzzy_detail' => [
                'input' => ['tugas' => $tugas, 'uts' => $uts, 'uas' => $uas],
                'membership' => $memberships,
                'aggregated' => $aggregated,
            ],
        ];
    }
}
