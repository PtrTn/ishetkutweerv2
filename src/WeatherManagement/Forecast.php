<?php

namespace WeatherManagement;

/**
 * Class Forecast
 * @package WeatherManagement
 */
class Forecast {

    /**
     * @var array
     */
    private $days;

    /**
     * @param Day $day
     */
    public function addDay(Day $day) {
        $this->days[] = $day;
    }

    /**
     * @return array
     */
    public function toArray() {
        $arrayValues = array();
        foreach($this->days as $day) {
            $arrayValues[] = $day->toArray();
        }
        return $arrayValues;
    }

    /**
     * @return Day
     */
    public function getToday() {
        return reset($this->days);
    }

} 