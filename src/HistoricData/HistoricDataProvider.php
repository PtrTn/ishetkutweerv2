<?php

namespace HistoricData;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Helpers\BeaufortCalculator;
use Location\Station;

class HistoricDataProvider
{
    private $connection;
    private $beaufortCalculator;

    public function __construct(Connection $connection, BeaufortCalculator $beaufortCalculator)
    {
        $this->connection = $connection;
        $this->beaufortCalculator = $beaufortCalculator;
    }

    public function getData($stationId)
    {
        $query = new QueryBuilder($this->connection);
        $query
            ->select('*')
            ->from('weatherdata')
            ->where('stationId = :stationId')
            ->orderBy('date', 'desc')
            ->setParameter('stationId', $stationId)
            ->setParameter('date', '%-' . date('m-d'));
        $where = '';
        $years = [2015, 2014, 2013];
        foreach($years as $index => $year) {
            $date = $year . '-' . date('m-d');
            $startDate = date('Y-m-d', strtotime('-7 days', strtotime($date)));
            $endDate = date('Y-m-d', strtotime('+7 days', strtotime($date)));
            if ($index !== 0) {
                $where .= ' OR ';
            }
            $where .= 'date BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
        }
        $query->andWhere($where);
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
        $historicCollection = new HistoricDataCollection();
        foreach ($rows as $row) {
            $stationId = $row['stationId'];
            $date = new \DateTime($row['date']);
            $tempAvg = floatval(round($row['tempAvg'] / 10, 1));
            $tempMin = floatval(round($row['tempMin'] / 10, 1));
            $tempMax = floatval(round($row['tempMax'] / 10, 1));
            $windSpeed = intval($row['windSpeed'] * 3.6 / 10);
            $windDirection = intval($row['windDirection']);
            $beaufort = $this->beaufortCalculator->getBeaufort($windSpeed);
            $rainSum = floatval(round($row['rainSum'] / 10, 1));
            $rainDuration = floatval(round($row['rainDuration'] / 10, 1));
            $rainMax = floatval(round($row['rainMax'] / 10, 1));
            if ($rainMax === -1) {
                $rainMax = 0;
            }
            $historicCollection->add(new HistoricWeatherData(
                $date,
                $windDirection,
                $windSpeed,
                $beaufort,
                $stationId,
                $tempAvg,
                $tempMin,
                $tempMax,
                $rainDuration,
                $rainSum,
                $rainMax
            ));
        }
        return $historicCollection;
    }

}
 