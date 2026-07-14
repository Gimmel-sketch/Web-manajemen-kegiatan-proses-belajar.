<?php

namespace App\Services;

class FuzzyLogicService
{
    protected array $membershipFunctions = [];
    protected array $rules = [];
    protected array $outputRanges = [];

    public function addMembershipFunction(string $variable, string $label, array $points, string $type = 'triangular'): self
    {
        $this->membershipFunctions[$variable][$label] = [
            'points' => $points,
            'type' => $type,
        ];
        return $this;
    }

    public function addRule(array $antecedents, string $consequent, string $outputLabel): self
    {
        $this->rules[] = [
            'antecedents' => $antecedents,
            'consequent' => $consequent,
            'output_label' => $outputLabel,
        ];
        return $this;
    }

    public function setOutputRange(string $variable, float $min, float $max): self
    {
        $this->outputRanges[$variable] = [$min, $max];
        return $this;
    }

    public function fuzzify(string $variable, float $value): array
    {
        $result = [];
        foreach ($this->membershipFunctions[$variable] ?? [] as $label => $mf) {
            $result[$label] = $this->calculateMembership($value, $mf['points'], $mf['type']);
        }
        return $result;
    }

    protected function calculateMembership(float $x, array $points, string $type): float
    {
        if ($type === 'triangular' && count($points) === 3) {
            return $this->triangular($x, $points[0], $points[1], $points[2]);
        }
        if ($type === 'trapezoidal' && count($points) === 4) {
            return $this->trapezoidal($x, $points[0], $points[1], $points[2], $points[3]);
        }
        return 0;
    }

    protected function triangular(float $x, float $a, float $b, float $c): float
    {
        if ($x <= $a || $x >= $c) return 0;
        if ($x === $b) return 1;
        if ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        return ($c - $x) / ($c - $b);
    }

    protected function trapezoidal(float $x, float $a, float $b, float $c, float $d): float
    {
        if ($x <= $a || $x >= $d) return 0;
        if ($x >= $b && $x <= $c) return 1;
        if ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        return ($d - $x) / ($d - $c);
    }

    public function evaluateRules(array $inputMemberships): array
    {
        $outputs = [];
        foreach ($this->rules as $rule) {
            $antecedentStrength = 1.0;
            foreach ($rule['antecedents'] as $antecedent) {
                $var = $antecedent['variable'];
                $label = $antecedent['label'];
                $degree = $inputMemberships[$var][$label] ?? 0;
                $antecedentStrength = min($antecedentStrength, $degree);
            }
            $outputVar = $rule['consequent'];
            $outputLabel = $rule['output_label'];
            if (!isset($outputs[$outputVar][$outputLabel])) {
                $outputs[$outputVar][$outputLabel] = 0;
            }
            $outputs[$outputVar][$outputLabel] = max($outputs[$outputVar][$outputLabel], $antecedentStrength);
        }
        return $outputs;
    }

    public function defuzzify(string $variable, array $aggregatedOutputs): float
    {
        if (!isset($this->outputRanges[$variable])) {
            return 0;
        }
        [$min, $max] = $this->outputRanges[$variable];
        $step = ($max - $min) / 100;
        $numerator = 0;
        $denominator = 0;
        for ($x = $min; $x <= $max; $x += $step) {
            $membership = 0;
            foreach ($aggregatedOutputs[$variable] ?? [] as $label => $strength) {
                if ($strength <= 0) continue;
                $mf = $this->membershipFunctions[$variable][$label] ?? null;
                if (!$mf) continue;
                $degree = min($strength, $this->calculateMembership($x, $mf['points'], $mf['type']));
                $membership = max($membership, $degree);
            }
            $numerator += $x * $membership;
            $denominator += $membership;
        }
        return $denominator > 0 ? round($numerator / $denominator, 2) : 0;
    }

    public function getLabel(float $value, array $definitions): string
    {
        $maxDegree = 0;
        $bestLabel = '-';
        foreach ($definitions as $label => $range) {
            $points = $range['points'] ?? [];
            $type = $range['type'] ?? 'triangular';
            $degree = $this->calculateMembership($value, $points, $type);
            if ($degree > $maxDegree) {
                $maxDegree = $degree;
                $bestLabel = $label;
            }
        }
        return $bestLabel;
    }

    public function nilaiToHuruf(float $nilaiAkhir): string
    {
        return match (true) {
            $nilaiAkhir >= 80 => 'A',
            $nilaiAkhir >= 65 => 'B',
            $nilaiAkhir >= 50 => 'C',
            $nilaiAkhir >= 35 => 'D',
            default => 'E',
        };
    }
}
