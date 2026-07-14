<?php

namespace App\Services;

class FuzzyKrsService
{
    protected FuzzyLogicService $fuzzy;

    public function __construct()
    {
        $this->fuzzy = new FuzzyLogicService();
        $this->setup();
    }

    protected function setup(): void
    {
        $this->fuzzy->addMembershipFunction('ipk', 'Rendah', [0, 0, 2.0], 'triangular');
        $this->fuzzy->addMembershipFunction('ipk', 'Sedang', [1.5, 2.75, 3.5], 'triangular');
        $this->fuzzy->addMembershipFunction('ipk', 'Tinggi', [2.8, 4.0, 4.0], 'triangular');

        $this->fuzzy->addMembershipFunction('beban_sks', 'Ringan', [0, 0, 2], 'triangular');
        $this->fuzzy->addMembershipFunction('beban_sks', 'Sedang', [1, 3, 4], 'triangular');
        $this->fuzzy->addMembershipFunction('beban_sks', 'Berat', [3, 6, 6], 'triangular');

        $this->fuzzy->addMembershipFunction('semester', 'Awal', [0, 0, 4], 'triangular');
        $this->fuzzy->addMembershipFunction('semester', 'Tengah', [2, 5, 8], 'triangular');
        $this->fuzzy->addMembershipFunction('semester', 'Akhir', [6, 14, 14], 'triangular');

        $this->fuzzy->addMembershipFunction('nilai_prasyarat', 'TidakLulus', [0, 0, 55], 'triangular');
        $this->fuzzy->addMembershipFunction('nilai_prasyarat', 'Lulus', [45, 100, 100], 'triangular');

        $this->fuzzy->addMembershipFunction('kelayakan', 'TidakLayak', [0, 0, 35], 'triangular');
        $this->fuzzy->addMembershipFunction('kelayakan', 'KurangLayak', [20, 40, 55], 'triangular');
        $this->fuzzy->addMembershipFunction('kelayakan', 'Layak', [40, 60, 75], 'triangular');
        $this->fuzzy->addMembershipFunction('kelayakan', 'SangatLayak', [65, 100, 100], 'triangular');

        $this->fuzzy->setOutputRange('kelayakan', 0, 100);

        $rules = [
            [['Rendah', 'Berat', 'Tengah', 'TidakLulus'], 'TidakLayak'],
            [['Rendah', 'Berat', 'Awal', 'TidakLulus'], 'TidakLayak'],
            [['Rendah', 'Berat', 'Awal', 'Lulus'], 'KurangLayak'],
            [['Rendah', 'Berat', 'Tengah', 'Lulus'], 'KurangLayak'],
            [['Rendah', 'Sedang', 'Awal', 'TidakLulus'], 'TidakLayak'],
            [['Rendah', 'Sedang', 'Awal', 'Lulus'], 'KurangLayak'],
            [['Rendah', 'Sedang', 'Tengah', 'Lulus'], 'KurangLayak'],
            [['Rendah', 'Ringan', 'Awal', 'Lulus'], 'Layak'],
            [['Rendah', 'Ringan', 'Awal', 'TidakLulus'], 'KurangLayak'],
            [['Rendah', 'Ringan', 'Tengah', 'Lulus'], 'Layak'],
            [['Rendah', 'Berat', 'Akhir', 'Lulus'], 'KurangLayak'],
            [['Rendah', 'Berat', 'Akhir', 'TidakLulus'], 'TidakLayak'],
            [['Sedang', 'Berat', 'Awal', 'Lulus'], 'Layak'],
            [['Sedang', 'Berat', 'Awal', 'TidakLulus'], 'KurangLayak'],
            [['Sedang', 'Berat', 'Tengah', 'Lulus'], 'Layak'],
            [['Sedang', 'Berat', 'Tengah', 'TidakLulus'], 'KurangLayak'],
            [['Sedang', 'Sedang', 'Awal', 'Lulus'], 'Layak'],
            [['Sedang', 'Sedang', 'Awal', 'TidakLulus'], 'KurangLayak'],
            [['Sedang', 'Sedang', 'Tengah', 'Lulus'], 'Layak'],
            [['Sedang', 'Sedang', 'Tengah', 'TidakLulus'], 'KurangLayak'],
            [['Sedang', 'Ringan', 'Awal', 'Lulus'], 'SangatLayak'],
            [['Sedang', 'Ringan', 'Awal', 'TidakLulus'], 'Layak'],
            [['Sedang', 'Ringan', 'Tengah', 'Lulus'], 'SangatLayak'],
            [['Sedang', 'Ringan', 'Tengah', 'TidakLulus'], 'Layak'],
            [['Sedang', 'Berat', 'Akhir', 'Lulus'], 'Layak'],
            [['Sedang', 'Berat', 'Akhir', 'TidakLulus'], 'KurangLayak'],
            [['Tinggi', 'Berat', 'Awal', 'Lulus'], 'SangatLayak'],
            [['Tinggi', 'Berat', 'Awal', 'TidakLulus'], 'Layak'],
            [['Tinggi', 'Berat', 'Tengah', 'Lulus'], 'SangatLayak'],
            [['Tinggi', 'Berat', 'Tengah', 'TidakLulus'], 'Layak'],
            [['Tinggi', 'Sedang', 'Awal', 'Lulus'], 'SangatLayak'],
            [['Tinggi', 'Sedang', 'Awal', 'TidakLulus'], 'Layak'],
            [['Tinggi', 'Sedang', 'Tengah', 'Lulus'], 'SangatLayak'],
            [['Tinggi', 'Sedang', 'Tengah', 'TidakLulus'], 'Layak'],
            [['Tinggi', 'Ringan', 'Awal', 'Lulus'], 'SangatLayak'],
            [['Tinggi', 'Ringan', 'Awal', 'TidakLulus'], 'SangatLayak'],
            [['Tinggi', 'Ringan', 'Tengah', 'Lulus'], 'SangatLayak'],
            [['Tinggi', 'Ringan', 'Tengah', 'TidakLulus'], 'Layak'],
            [['Tinggi', 'Berat', 'Akhir', 'Lulus'], 'Layak'],
            [['Tinggi', 'Berat', 'Akhir', 'TidakLulus'], 'KurangLayak'],
            [['Tinggi', 'Sedang', 'Akhir', 'Lulus'], 'SangatLayak'],
            [['Tinggi', 'Sedang', 'Akhir', 'TidakLulus'], 'Layak'],
            [['Rendah', 'Sedang', 'Akhir', 'TidakLulus'], 'TidakLayak'],
            [['Rendah', 'Sedang', 'Akhir', 'Lulus'], 'KurangLayak'],
            [['Rendah', 'Ringan', 'Akhir', 'Lulus'], 'Layak'],
            [['Rendah', 'Ringan', 'Akhir', 'TidakLulus'], 'KurangLayak'],
        ];

        foreach ($rules as $rule) {
            $this->fuzzy->addRule(
                [
                    ['variable' => 'ipk', 'label' => $rule[0][0]],
                    ['variable' => 'beban_sks', 'label' => $rule[0][1]],
                    ['variable' => 'semester', 'label' => $rule[0][2]],
                    ['variable' => 'nilai_prasyarat', 'label' => $rule[0][3]],
                ],
                'kelayakan',
                $rule[1]
            );
        }
    }

    public function hitungKelayakan(
        float $ipk,
        int $bebanSks,
        int $semester,
        ?float $nilaiPrasyarat = null
    ): array {
        $nilaiPrasyarat = $nilaiPrasyarat ?? 60;

        $memberships = [
            'ipk' => $this->fuzzy->fuzzify('ipk', $ipk),
            'beban_sks' => $this->fuzzy->fuzzify('beban_sks', $bebanSks),
            'semester' => $this->fuzzy->fuzzify('semester', $semester),
            'nilai_prasyarat' => $this->fuzzy->fuzzify('nilai_prasyarat', $nilaiPrasyarat),
        ];

        $aggregated = $this->fuzzy->evaluateRules($memberships);
        $skor = $this->fuzzy->defuzzify('kelayakan', $aggregated);

        $definitions = [
            'TidakLayak' => ['points' => [0, 0, 35], 'type' => 'triangular'],
            'KurangLayak' => ['points' => [20, 40, 55], 'type' => 'triangular'],
            'Layak' => ['points' => [40, 60, 75], 'type' => 'triangular'],
            'SangatLayak' => ['points' => [65, 100, 100], 'type' => 'triangular'],
        ];
        $label = $this->fuzzy->getLabel($skor, $definitions);

        return [
            'skor' => $skor,
            'label' => $label,
            'fuzzy_detail' => [
                'input' => [
                    'ipk' => $ipk,
                    'beban_sks' => $bebanSks,
                    'semester' => $semester,
                    'nilai_prasyarat' => $nilaiPrasyarat,
                ],
                'membership' => $memberships,
                'aggregated' => $aggregated,
            ],
        ];
    }
}
