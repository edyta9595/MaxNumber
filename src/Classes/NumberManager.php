<?php

namespace App\Classes;

class NumberManager
{
    private $maxValuesInSeries;
    private $temporarySeries;

    public function getMaxValuesInSeriesWithGivenSizes($testCases)
    {
        $notEmptyTestCases = $this->removeEmptyTestCases($testCases);
        $this->countMaxValueForEachSeries($notEmptyTestCases);

        return $this->displaySizeOfSeriesAndMaxValues();
    }

    private function countMaxValueForEachSeries($seriesSizes)
    {
        foreach($seriesSizes as $n)
        {
            $this->maxValuesInSeries[$n] = $this->getMaxValueInSeries($n);
        }
    }

    private function getMaxValueInSeries($seriesSize)
    {
        $maxValue = 1;
        $this->temporarySeries = [0, 1];

        for($seriesIndex = 2; $seriesIndex <= $seriesSize; $seriesIndex++)
        {
            $newElement = $this->countNewElement($seriesIndex);    
            $maxValue = $this->getTempMaxValue($newElement, $maxValue);
        }
        return $maxValue;
    }

    private function getTempMaxValue($newElement, $maxValue)
    {
        if ($newElement > $maxValue)
            $maxValue = $newElement;
        
        return $maxValue;
    }

    private function countNewElement($seriesIndex)
    {
         $newElement = $seriesIndex % 2 === 0 ? $$this->temporarySeries[$seriesIndex / 2] : $this->temporarySeries[($seriesIndex - 1) / 2] + $this->temporarySeries[$seriesIndex / 2 + 1]; 
         array_push($this->temporarySeries, $newElement);
         return $newElement;
    }

    private function removeEmptyTestCases($testCases)
    {
        return array_filter($testCases, function ($value)
        {
            return $value !== null;
        });
    }

    private function displaySizeOfSeriesAndMaxValues()
    {
        $results = '';
        foreach((array)$this->maxValuesInSeries as $key => $value)
            $results .= 'For test case n = ' . $key . ' max value = ' . $value . PHP_EOL; 

        return $results;
    }
}