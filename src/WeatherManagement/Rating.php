<?php

namespace WeatherManagement;

/**
 * Class Rating
 * @package WeatherManagement
 */
class Rating {

    /**
     * @var
     */
    private $indicator;

    /**
     * @var
     */
    private $text;

    /**
     * @param $indicator
     * @param string $text
     */
    public function __construct($indicator, $text = '') {
        $this->indicator = $indicator;
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getIndicator() {
        return $this->indicator;
    }

    /**
     * @return mixed
     */
    public function getText() {
        return $this->text;
    }

} 