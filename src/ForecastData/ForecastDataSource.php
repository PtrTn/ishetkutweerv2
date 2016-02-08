<?php

namespace ForecastData;

use Interfaces\DataSource;
use Location\LocationDataBlock;
use VertigoLabs\Overcast\Overcast;

class ForecastDataSource implements DataSource
{
    private $overcast;

    public function __construct(Overcast $overcast, ForecastDataFactory $dataFactory)
    {
        $this->overcast = $overcast;
        $this->dataFactory = $dataFactory;
    }

    public function getData(LocationDataBlock $location = null)
    {
        $data = $this->overcast->getForecast(
            $location->getLat(),
            $location->getLon(),
            null,
            ['units' => 'ca']
        );
        return $this->dataFactory->createDataBlock($data);
    }
}
 