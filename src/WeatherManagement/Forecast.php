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
     * @var
     */
    private $message;

    /**
     * @var
     */
    private $location;

    /**
     * @param $location
     */
    public function __construct($location) {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * @param Day $day
     */
    public function addDay(Day $day) {
        $this->days[] = $day;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @return day
     */
    public function getToday() {
        return reset($this->days);
    }

    /**
     * @return array
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