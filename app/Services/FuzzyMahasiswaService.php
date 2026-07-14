<?php

namespace App\Services;

class FuzzyMahasiswaService
{
    protected FuzzyLogicService $fuzzy;

    public function __construct()
    {
        $this->fuzzy = new FuzzyLogicService();
        $this->setup();
    }

    protected function setup(): void
    {
        $this->fuzzy->addMembershipFunction('rata_nilai', 'Rendah', [0, 0, 45], 'triangular');
        $this->fuzzy->addMembershipFunction('rata_nilai', 'Sedang', [30, 55, 80], 'triangular');
        $this->fuzzy->addMembershipFunction('rata_nilai', 'Tinggi', [60, 100, 100], 'triangular');

        $this->fuzzy->addMembershipFunction('ipk', 'Rendah', [0, 0, 2.0], 'triangular');
        $this->fuzzy->addMembershipFunction('ipk', 'Sedang', [1.5, 2.5, 3.5], 'triangular');
        $this->fuzzy->addMembershipFunction('ipk', 'Tinggi', [2.8, 4.0, 4.0], 'triangular');

        $this->fuzzy->addMembershipFunction('sks_lulus', 'Sedikit', [0, 0, 40], 'triangular');
        $this->fuzzy->addMembershipFunction('sks_lulus', 'Cukup', [20, 60, 100], 'triangular');
        $this->fuzzy->addMembershipFunction('sks_lulus', 'Banyak', [60, 144, 144], 'triangular');

        $this->fuzzy->addMembershipFunction('performa', 'Kurang', [0, 0, 40], 'triangular');
        $this->fuzzy->addMembershipFunction('performa', 'Cukup', [25, 50, 75], 'triangular');
        $this->fuzzy->addMembershipFunction('performa', 'Baik', [50, 75, 90], 'triangular');
        $this->fuzzy->addMembershipFunction('performa', 'SangatBaik', [75, 100, 100], 'triangular');

        $this->fuzzy->setOutputRange('performa', 0, 100);

        $rules = [
            [['Rendah', 'Rendah', 'Sedikit'], 'Kurang'],
            [['Rendah', 'Rendah', 'Cukup'], 'Kurang'],
            [['Rendah', 'Sedang', 'Sedikit'], 'Kurang'],
            [['Rendah', 'Sedang', 'Cukup'], 'Cukup'],
            [['Rendah', 'Tinggi', 'Cukup'], 'Cukup'],
            [['Sedang', 'Rendah', 'Sedikit'], 'Kurang'],
            [['Sedang', 'Rendah', 'Cukup'], 'Cukup'],
            [['Sedang', 'Sedang', 'Sedikit'], 'Cukup'],
            [['Sedang', 'Sedang', 'Cukup'], 'Baik'],
            [['Sedang', 'Sedang', 'Banyak'], 'Baik'],
            [['Sedang', 'Tinggi', 'Cukup'], 'Baik'],
            [['Sedang', 'Tinggi', 'Banyak'], 'SangatBaik'],
            [['Tinggi', 'Rendah', 'Sedikit'], 'Cukup'],
            [['Tinggi', 'Rendah', 'Cukup'], 'Cukup'],
            [['Tinggi', 'Sedang', 'Sedikit'], 'Baik'],
            [['Tinggi', 'Sedang', 'Cukup'], 'Baik'],
            [['Tinggi', 'Sedang', 'Banyak'], 'SangatBaik'],
            [['Tinggi', 'Tinggi', 'Sedikit'], 'Baik'],
            [['Tinggi', 'Tinggi', 'Cukup'], 'SangatBaik'],
            [['Tinggi', 'Tinggi', 'Banyak'], 'SangatBaik'],
        ];

        foreach ($rules as $rule) {
            $this->fuzzy->addRule(
                [
                    ['variable' => 'rata_nilai', 'label' => $rule[0][0]],
                    ['variable' => 'ipk', 'label' => $rule[0][1]],
                    ['variable' => 'sks_lulus', 'label' => $rule[0][2]],
                ],
                'performa',
                $rule[1]
            );
        }
    }

    public function evaluasi(float $rataNilai, float $ipk, int $sksLulus): array
    {
        $memberships = [
            'rata_nilai' => $this->fuzzy->fuzzify('rata_nilai', $rataNilai),
            'ipk' => $this->fuzzy->fuzzify('ipk', $ipk),
            'sks_lulus' => $this->fuzzy->fuzzify('sks_lulus', $sksLulus),
        ];

        $aggregated = $this->fuzzy->evaluateRules($memberships);
        $skor = $this->fuzzy->defuzzify('performa', $aggregated);

        $definitions = [
            'Kurang' => ['points' => [0, 0, 40], 'type' => 'triangular'],
            'Cukup' => ['points' => [25, 50, 75], 'type' => 'triangular'],
            'Baik' => ['points' => [50, 75, 90], 'type' => 'triangular'],
            'Sangat Baik' => ['points' => [75, 100, 100], 'type' => 'triangular'],
        ];
        $label = $this->fuzzy->getLabel($skor, $definitions);

        return [
            'skor' => $skor,
            'label' => $label,
            'fuzzy_detail' => [
                'input' => [
                    'rata_rata_nilai' => $rataNilai,
                    'ipk' => $ipk,
                    'sks_lulus' => $sksLulus,
                ],
                'membership' => $memberships,
                'aggregated' => $aggregated,
            ],
        ];
    }
}
