<?php

namespace WeatherManagement;

/**
 * Class Day
 * @package WeatherManagement
 */
class Day {

    /**
     * @var
     */
    private $date;

    /**
     * @var Measurement
     */
    private $rain;

    /**
     * @var Measurement
     */
    private $temp;

    /**
     * @var Measurement
     */
    private $wind;

    /**
     * @var
     */
    private $rating;

    /**
     * @param $date
     * @param Measurement $rain
     * @param Measurement $temp
     * @param Measurement $wind
     */
    public function __construct($date, Measurement $rain, Measurement $temp, Measurement $wind) {
        $this->date = $date;
        $this->rain = $rain;
        $this->temp = $temp;
        $this->wind = $wind;
        $this->rating = '';
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'day' => $this->getDayOfWeek($this->date),
            'rain' => $this->rain->getAverage(),
            'temp' => $this->temp->getAverage(),
            'wind' => $this->wind->getAverage(),
        ];
    }

    /**
     * @return array
     */
    public function getStatus() {
        return [
            'message' => $this->rating->getText(),
            'indicator' => $this->rating->getIndicator()
        ];
    }

    /**
     * @return array
     */
    public function toEnrichedArray() {
        return [
            'rain' => [
                'value' => $this->rain->getAverage(),
                'indicatior' => $this->rain->getRating()->getIndicator()
            ],
            'temp' => [
                'value' => $this->temp->getAverage(),
                'indicatior' => $this->temp->getRating()->getIndicator()
            ],
            'wind' => [
                'value' => $this->wind->getAverage(),
                'indicatior' => $this->wind->getRating()->getIndicator()
            ]
        ];
    }

    /**
     * @return Measurement
     */
    public function getRain() {
        return $this->rain;
    }

    /**
     * @return Measurement
     */
    public function getTemp() {
        return $this->temp;
    }

    /**
     * @return Measurement
     */
    public function getWind() {
        return $this->wind;
    }

    /**
     * @param $rating
     */
    public function setRating(Rating $rating) {
        $this->rating = $rating;
    }

    /**
     * @param $date
     * @return string
     */
    private function getDayOfWeek($date) {
        $days = ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'];
        return $days[date('w', $date)];
    }

} 