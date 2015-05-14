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
     *
     */
    public function getTodayStatus() {
        return reset($this->days)->getStatus();
    }

    /**
     * @return array
     */
    public function getTodayData() {
        return reset($this->days)->toEnrichedArray();
    }

    /**
     * @return array
     */
    public function getForecastData() {
        $arrayValues = array();
        foreach($this->days as $day) {
            $arrayValues[] = $day->toArray();
        }
        return $arrayValues;
    }

} 