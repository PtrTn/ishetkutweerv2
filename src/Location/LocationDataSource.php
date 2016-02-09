<?php

namespace Location;

use Doctrine\DBAL\Query\QueryBuilder;
use Helpers\IpNumber;
use Interfaces\DataFactory;
use Interfaces\DataSource;
use Doctrine\DBAL\Connection;

class LocationDataSource implements DataSource
{
    private $dataFactory;
    private $connection;

    public function __construct(DataFactory $dataFactory, Connection $connection)
    {
        $this->dataFactory = $dataFactory;
        $this->connection = $connection;
    }

    public function getData($ip = null)
    {
        // Create query based on stationId
        $ipNumber = ip2long($ip);
        $query = $this->getQuery($ipNumber);

        // Execute query
        $statement = $query->execute();
        $data = $statement->fetch();

        // Create DataBlocks based on query result
        return $this->dataFactory->createDataBlock($data);
    }

    private function getQuery($ipNumber)
    {
        $query = new QueryBuilder($this->connection);
        $query
            ->select('*')
            ->from('ipdata')
            ->where(':ipNumber <= ip_to')
            ->setParameter('ipNumber', $ipNumber)
            ->setMaxResults(1);
        return $query;
    }
}
 