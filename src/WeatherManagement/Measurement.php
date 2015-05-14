<?php

namespace WeatherManagement;

/**
 * Class Measurement
 * @package WeatherManagement
 */
class Measurement {

    /**
     * @var int
     */
    private $avg;

    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * @var Rating
     */
    private $rating;

    /**
     * @param string $type
     * @param int $avg
     * @param mixed $min
     * @param mixed $max
     */
    public function __construct($type, $avg, $min = false, $max = false) {
        $this->type = $type;
        $this->avg = $avg;
        $this->min = $min;
        $this->max = $max;
        $this->rating = '';
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param Rating $rating
     */
    public function setRating(Rating $rating) {
        $this->rating = $rating;
    }

    /**
     * @return Rating
     */
    public function getRating() {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getAverage() {
        if(isset($this->avg) && $this->avg !== false) {
            return $this->avg;
        }
        if(!isset($this->min) || !isset($this->max)) {
            throw new \InvalidArgumentException('No valid average, minimum or maximum have been specified');
        }
        return intval(($this->max - $this->min ) / 2);
    }

} 