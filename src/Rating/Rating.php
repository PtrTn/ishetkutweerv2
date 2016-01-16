<?php

namespace Rating;

class Rating
{
    private $rainRating;
    private $tempRating;
    private $windRating;

    public function __construct($rainRating, $tempRating, $windRating)
    {
        $this->rainRating = $rainRating;
        $this->tempRating = $tempRating;
        $this->windRating = $windRating;
    }

    public function getOverall()
    {
        $average = ($this->rainRating = $this->tempRating + $this->windRating) / 3;
        return round($average);
    }

    public function getRain()
    {
        return $this->rainRating;
    }

    public function getTemp()
    {
        return $this->tempRating;
    }

    public function getWind()
    {
        return $this->windRating;
    }

}
 