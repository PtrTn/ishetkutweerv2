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
        return $this->toClass($this->getAvgRating());
    }

    public function getMessage()
    {
        switch($this->getAvgRating()) {
            case 2:
                return 'Het is geen kutweer!';
            case 1:
                return 'Het is redelijk kutweer!';
            case 0:
                return 'Het is kutweer!';
            default:
                return 'Het is misschien kutweer!';
        }
    }

    public function getShortMessage()
    {
        switch($this->getAvgRating()) {
            case 2:
                return 'Niet kut';
            case 1:
                return 'Redelijk';
            case 0:
                return 'Kut';
            default:
                return 'Misschien kut';
        }
    }

    public function getTemp()
    {
        return $this->toClass($this->tempRating);
    }

    public function getRain()
    {
        return $this->toClass($this->rainRating);
    }

    public function getWind()
    {
        return $this->toClass($this->windRating);
    }

    private function toClass($rating)
    {
        switch($rating) {
            case 2:
                return 'good';
            case 1:
                return 'meh';
            case 0:
                return 'bad';
            default:
                return 'neutral';
        }
    }

    private function getAvgRating()
    {
        $average = ($this->rainRating + $this->tempRating + $this->windRating) / 3;
        return round($average);
    }

}
 