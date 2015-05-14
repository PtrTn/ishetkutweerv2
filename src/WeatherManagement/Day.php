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
            'message' => 'Het is geen kutweer',
            'indicator' => 'good'
        ];
    }

    /**
     * @return array
     */
    public function toEnrichedArray() {
        return [
            'rain' => [
                'value' => $this->rain->getAverage(),
                'indicatior' => 'meh'
            ],
            'temp' => [
                'value' => $this->temp->getAverage(),
                'indicatior' => 'good'
            ],
            'wind' => [
                'value' => $this->wind->getAverage(),
                'indicatior' => 'bad'
            ]
        ];
    }

    private function getDayOfWeek($date) {
        $days = ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'];
        return $days[date('w', $date)];
    }

} 