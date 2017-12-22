<?php

namespace HistoricData;

use Abstractions\Collection;
use Interfaces\DataBlock;

class HistoryDataCollection extends Collection
{
    public function add(DataBlock $dataBlock)
    {
        parent::add($dataBlock);
    }

    public function getRainAvg()
    {
        $rainSumAvg = $this->getStatAvg('rainSum', 1);
        $rainDurationAvg = $this->getStatAvg('rainDuration', 1);
        if ($rainDurationAvg > 0) {
            return round($rainSumAvg / $rainDurationAvg, 1);
        }
        return 0;
    }

    public function getTempAvg()
    {
        return $this->getStatAvg('temp', 1);
    }

    public function getTempMinAvg()
    {
        return $this->getStatAvg('tempMin', 1);
    }

    public function getTempMaxAvg()
    {
        return $this->getStatAvg('tempMax', 1);
    }

    public function getWindSpeedAvg()
    {
        return $this->getStatAvg('wind', 0);
    }

    public function getBeaufortAvg()
    {
        return $this->getStatAvg('beaufort', 0);
    }

    public function getRainMaxAvg()
    {
        return $this->getStatAvg('rainMax', 1);
    }

    private function getStatAvg($stat, $precision)
    {
        $total = 0;
        $count = 0;
        foreach ($this->dataBlocks as $weatherData) {
            if ($weatherData->isValid()) {
                switch($stat) {
                    case 'rainSum':
                        $total += $weatherData->getRainSum();
                        break;
                    case 'rainDuration':
                        $total += $weatherData->getRainDuration();
                        break;
                    case 'rainMax':
                        $total += $weatherData->getRainMax();
                        break;
                    case 'temp':
                        $total += $weatherData->getTempAvg();
                        break;
                    case 'tempMin':
                        $total += $weatherData->getTempMin();
                        break;
                    case 'tempMax':
                        $total += $weatherData->getTempMax();
                        break;
                    case 'wind':
                        $total += $weatherData->getWindSpeed();
                        break;
                    case 'beaufort':
                        $total += $weatherData->getBeaufort();
                        break;
                    default:
                        throw new \Exception('No stat found called "' . $stat . '"');
                }
                $count++;
            }
        }
        $average = $total / $count;
        return round($average, $precision);
    }
}
 