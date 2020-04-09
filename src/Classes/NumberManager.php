<?php

namespace App\Classes;

class NumberManager
{
    private $maxValues;

    public function getMaxValues($testCases)
    {
        foreach($this->filterTestCases($testCases) as $testCase)
        {
            $this->maxValues[$testCase] = $this->maxValueInSeries($testCase);
        }

        return $this->displayMaxValues();
    }

    private function maxValueInSeries($lastIndex)
    {
        $maxValue = 1;
        $series = [0, 1];
        for($currentIndex = 2; $currentIndex <= $lastIndex; $currentIndex++)
        {
            $currentValue = $this->getCurrentValue($series, $currentIndex);
            array_push($series, $currentValue);

            if ($currentValue > $maxValue)
                $maxValue = $currentValue;
        }
        return $maxValue;
    }

    private function getCurrentValue($series, $currentIndex)
    {
        return $currentIndex % 2 === 0 ? $series[$currentIndex / 2] : $series[($currentIndex - 1) / 2] + $series[$currentIndex / 2 + 1]; 
    }

    private function filterTestCases($testCases)
    {
        return array_filter($testCases, function ($value)
        {
            return $value !== null;
        });
    }

    private function displayMaxValues()
    {
        $results = '';
        foreach((array)$this->maxValues as $key => $value)
            $results .= 'For test case n = ' . $key . ' max value = ' . $value . PHP_EOL; 

        return $results;
    }
}