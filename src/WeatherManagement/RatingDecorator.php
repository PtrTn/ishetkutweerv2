<?php

namespace WeatherManagement;

/**
 * Class RatingDecorator
 * @package WeatherManagement
 */
class RatingDecorator {

    /**
     * @var array
     */
    private $ratings;

    public function __construct() {
        $this->ratings = [
            'rain' => [
                'inverted' => false,
                'min' => 0,
                'max' => 3
            ],
            'temp' => [
                'inverted' => true,
                'min' => 5,
                'max' => 15
            ],
            'wind' => [
                'inverted' => false,
                'min' => 20,
                'max' => 50
            ]
        ];
        $this->messages = [
            'Nee, het is geen kutweer',
            'Het is redelijk kutweer',
            'Ja, het is kutweer!'
        ];
        $this->values = [
            'good',
            'meh',
            'bad'
        ];
    }

    /**
     * @param Forecast $forecast
     * @return Forecast
     */
    public function decorate(Forecast $forecast) {
        $today = $forecast->getToday();
        $rainRating = $this->rateMeasurement($today->getRain());
        $tempRating =  $this->rateMeasurement($today->getTemp());
        $windRating = $this->rateMeasurement($today->getWind());
        $this->rateOverall($today, [$rainRating, $tempRating, $windRating]);
        return $forecast;
    }

    /**
     * @param Day $today
     * @param $ratings
     */
    private function rateOverall(Day $today, $ratings) {
        $average = array_sum($ratings) / count($ratings);
        $rounded = intval(round($average));
        $today->setRating($this->messages[$rounded]);
    }

    /**
     * @param Measurement $measurement
     * @return string
     */
    private function rateMeasurement(Measurement $measurement) {
        $ratings = $this->ratings[$measurement->getType()];
        $rating = $this->determineRating(
            $measurement->getAverage(),
            $ratings['min'],
            $ratings['max'],
            $ratings['inverted']
        );
        $measurement->setRating($this->values[$rating]);
        return $rating;
    }

    /**
     * @param int $value
     * @param int $min
     * @param int $max
     * @param bool $inverted
     * @return string
     */
    private function determineRating($value, $min, $max, $inverted) {
        if($inverted === false) {
            if($value >= $max) {
                return 2;
            }
            if($value <= $min) {
                return 0;
            }
            return 1;
        }
        if($inverted === true) {
            if($value >= $max) {
                return 0;
            }
            if($value <= $min) {
                return 2;
            }
            return 1;
        }
        throw new \InvalidArgumentException('No rating could be found for measurement');
    }
} 