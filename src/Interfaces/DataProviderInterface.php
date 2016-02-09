<?php

namespace Interfaces;

use Location\LocationDataBlock;

interface DataProviderInterface
{
    public function getDataByLocation(LocationDataBlock $location);
}
 