<?php

namespace HistoricData;

use Interfaces\DataFactory;

class HistoryDataFactory implements DataFactory
{
    public function createDataBlock($data)
    {
        $historyCollection = new HistoryDataCollection();
        foreach ($data as $row) {
            $historyCollection->add(new HistoryDataBlock(
                $row['stationId'],
                $row['date'],
                $row['tempAvg'],
                $row['tempMin'],
                $row['tempMax'],
                $row['rainDuration'],
                $row['rainSum'],
                $row['rainMax'],
                $row['windSpeed'],
                $row['windDirection']
            ));
        }
        return $historyCollection;
    }

}
 