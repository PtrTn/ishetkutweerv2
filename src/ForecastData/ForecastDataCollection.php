<?php

namespace ForecastData;

use AbstractClasses\Collection;

class ForecastDataCollection extends Collection
{

    public function add(ForecastDataBlock $dayDataBlock)
    {
        $date = $dayDataBlock->getDate()->format('Y-m-d');
        parent::addByKeyValue($date, $dayDataBlock);
    }

    public function getToday()
    {
        if (isset($this->dataBlocks[date('Y-m-d')])) {
            return $this->dataBlocks[date('Y-m-d')];
        }
        return false;
    }
}
 