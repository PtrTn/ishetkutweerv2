<?php

namespace DataProviding;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Location\Station;

class HistoricDataProvider
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getData($stationId)
    {
        $query = new QueryBuilder($this->connection);
        $query
            ->select('*')
            ->from('weatherdata')
            ->where('date LIKE :date')
            ->andWhere('stationId = :stationId')
            ->orderBy('date', 'desc')
            ->setParameter('stationId', $stationId)
            ->setParameter('date', '%-' . date('m-d'));
        $statement = $query->execute();
        return $statement->fetchAll();

    }

    public function getDataByStation(Station $station)
    {
        $knmiId = $station->getKnmiId();
        $rows = $this->getData($knmiId);
        return $this->toWeatherData($rows);
    }

    private function toWeatherData($rows)
    {
        $historicCollection = [];
        foreach ($rows as $row) {
            $date = date('d-m-Y', strtotime($row['date']));
            $tempAvg = floatval(round($row['tempAvg'] / 10, 1));
            $tempMin = floatval(round($row['tempMin'] / 10, 1));
            $tempMax = floatval(round($row['tempMax'] / 10, 1));
            $windSpeed = intval($row['windSpeed']);
            $windDirection = intval($row['windDirection']);
            $rainSum = floatval(round($row['rainSum'] / 10, 1));
            $rainDuration = floatval(round($row['rainDuration'] / 10, 1));
            $rainMax = floatval(round($row['rainMax'] / 10, 1));
            if ($rainMax === -1) {
                $rainMax = 0;
            }
            $historicCollection[] = new HistoricWeatherData(
                $row['stationId'],
                $date,
                $windDirection,
                $windSpeed,
                $tempAvg,
                $tempMin,
                $tempMax,
                $rainDuration,
                $rainSum,
                $rainMax
            );
        }
        return $historicCollection;
    }

}
 