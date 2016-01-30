<?php

namespace Interfaces;

use Location\Location;

interface DataProviderInterface
{
    public function getDataByLocation(Location $location);
}
 