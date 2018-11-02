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

    private $mode = 0;

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

    public function setDaylyMode() {
        $this->mode = 0;
    }
    public function setRangeMode() {
        $this->mode = 1;
    }

    public function calculate()
    {
        if ($this->mode == 0) {
            $this->notAnswered = $this->calculateNotAnswered();
            $this->summNotAnswered = array_sum($this->notAnswered);
        } else {
            $this->notAnswered = $this->calculateNotAnsweredForRange();
            $this->summNotAnswered = array_sum($this->notAnswered);
        }
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
        $summN = $this->calculateSumByPercent($this->summAnswered, $this->summNotAnswered);

        return array_map(function ($p) use ($summN) {
            return round(($p * $summN)/100, 0);
        }, $percentsForRowsNotAnswered);
    }

    private function calculateNotAnsweredForRange()
    {
        //$percent = $this->desiredPercent;
        return array_map(function ($answered, $notAnswered) {
            return $this->calculateSumByPercent($answered, $notAnswered);
        }, $this->answered, $this->notAnswered);
    }

    private function calculateSumByPercent($summA, $summB): int
    {
        $summN = $summB;
        while(true) {
            $summ = ($summA + $summN);
            $percent = ($summN * 100)/ $summ;

            if (abs($percent - $this->desiredPercent) < 0.0001) {
                break;
            }
            if ($percent > $this->desiredPercent) {
                $summN /= 2;
            } else if ($percent < $this->desiredPercent) {
                $summN *=1.5;
            }
        }
        return round($summN);
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