<?php

namespace ForecastData;

use Interfaces\DataSource;
use Location\LocationDataBlock;
use VertigoLabs\Overcast\Overcast;

class ForecastDataSource implements DataSource
{
    private $dataFactory;
    private $overcast;

    public function __construct(ForecastDataFactory $dataFactory, Overcast $overcast)
    {
        $this->dataFactory = $dataFactory;
        $this->overcast = $overcast;
    }

    public function getData(LocationDataBlock $location = null)
    {
        if (is_null($location)) {
            throw new \LogicException('No location provided for ForecastDataSource');
        }
        $data = $this->overcast->getForecast(
            $location->getLat(),
            $location->getLon(),
            null,
            ['units' => 'ca']
        );
        return $this->dataFactory->createDataBlock($data);
    }
}
 