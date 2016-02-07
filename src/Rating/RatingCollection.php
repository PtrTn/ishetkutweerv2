<?php

namespace Rating;

class RatingCollection
{
    private $ratings;

    public function __construct()
    {
        $this->ratings = [];
    }

    public function add(\DateTime $dateTime, Rating $rating)
    {
        $this->ratings[$dateTime->format('Y-m-d')] = $rating;
    }

    public function getByDate(\DateTime $dateTime)
    {
        if(isset($this->ratings[$dateTime->format('Y-m-d')])) {
            return $this->ratings[$dateTime->format('Y-m-d')];
        }
        return false;
    }

}
 