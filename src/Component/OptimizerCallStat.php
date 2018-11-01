<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 01.11.18
 * Time: 14:40
 */

namespace App\Component;


class OptimizerCallStat
{
    private $desiredPercent = 5;
    private $answered;
    private $notAnswered;
    private $summAnswered = 0;
    private $summNotAnswered = 0;

    public function __construct(array $answered, array $notAnswered)
    {
        $this->answered = $answered;
        $this->notAnswered = $notAnswered;
        $this->summAnswered = array_sum($this->answered);
        $this->summNotAnswered = array_sum($this->notAnswered);
    }

    public function setDesiredPercent($percent)
    {
        $this->desiredPercent = floatval($percent);
    }

    public function calculate()
    {
        $this->notAnswered = $this->calculateNotAnswered();
        $this->summNotAnswered = array_sum($this->notAnswered);
    }

    public function getNotAnswered(): ?array
    {
        return $this->notAnswered;
    }

    public function getSumNotAnswered(): ?int
    {
        return $this->summNotAnswered;
    }

    private function calculateNotAnswered()
    {
        $percentsForRowsNotAnswered = $this->calculatePercentForRows($this->notAnswered, $this->summNotAnswered);
        $summN = $this->calculateSum($this->summAnswered, $this->summNotAnswered);

        return array_map(function ($p) use ($summN) {
            return intval(($p * $summN)/100);
        }, $percentsForRowsNotAnswered);
    }

    private function calculateSum($summA, $summB): int
    {
        $summN = $summB;
        while(true) {
            $summ = ($summA + $summN);
            $percent = ($summN * 100)/ $summ;

            if (abs($percent - $this->desiredPercent) < 2) {
                break;
            }
            if ($percent > $this->desiredPercent) {
                $summN /= 2;
            } else if ($percent < $this->desiredPercent) {
                $summN *=1.5;
            }
        }
        return intval($summN);
    }

    private function calculatePercentForRows(array $array, int $summ)
    {
        $percentes = [];
        foreach ($array as $row) {
            $percentes[] = ($row * 100)/$summ;
        }

        return $percentes;
    }



}