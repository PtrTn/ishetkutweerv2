<?php

namespace DataProviding;

class HistoricDataCollection
{
    private $collection;

    public function __construct()
    {
        $this->collection = [];
    }

    public function add(HistoricWeatherData $weatherData)
    {
        $this->collection[] = $weatherData;
    }

    public function getRainAvg()
    {
        $rainSumAvg = $this->getStatAvg('rainSum', 1);
        $rainDurationAvg = $this->getStatAvg('rainDuration', 1);
        return round($rainSumAvg / $rainDurationAvg, 1);
    }

    public function getTempAvg()
    {
        return $this->getStatAvg('temp', 1);
    }

    public function getWindSpeedAvg()
    {
        return $this->getStatAvg('wind', 0);
    }

    private function getStatAvg($stat, $precision)
    {
        $total = 0;
        $count = 0;
        foreach ($this->collection as $weatherData) {
            // TODO check for enough valid entries
            if ($weatherData->isValid()) {
                switch($stat) {
                    case 'rainSum':
                        $total += $weatherData->getRainSum();
                        break;
                    case 'rainDuration':
                        $total += $weatherData->getRainDuration();
                        break;
                    case 'temp':
                        $total += $weatherData->getTempAvg();
                        break;
                    case 'wind':
                        $total += $weatherData->getWindSpeed();
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
 