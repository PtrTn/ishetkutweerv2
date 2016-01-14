<?php

namespace DataProviding;

class PresentMessage
{
    private $shortMsg;
    private $longMsg;

    public function __construct($shortMsg, $longMsg)
    {
        $this->shortMsg = $shortMsg;
        $this->longMsg = $longMsg;
    }
}
 