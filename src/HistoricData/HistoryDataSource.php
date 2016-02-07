<?php

namespace HistoricData;

use Doctrine\DBAL\Query\QueryBuilder;
use Interfaces\DataFactory;
use Interfaces\DataSource;
use Doctrine\DBAL\Connection;
use Location\Station;

class HistoryDataSource implements DataSource
{
    private $connection;
    private $dataFactory;

    // TODO maybe use database connector class?
    public function __construct(Connection $connection, DataFactory $dataFactory)
    {
        $this->connection = $connection;
        $this->dataFactory = $dataFactory;
    }

    public function getData(Station $station = null)
    {
        // Create query based on stationId
        $query = $this->getQuery($station->getKnmiId());

        // Execute query
        $statement = $query->execute();
        $data = $statement->fetchAll();

        // Create DataBlocks based on query result
        return $this->dataFactory->createDataBlock($data);
    }

    private function getQuery($stationId)
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
        return $query;
    }
}
 