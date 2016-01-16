<?php

namespace PresentData;

class PresentMessageProvider
{
    private $source;

    public function __construct()
    {
        $this->source = 'ftp://ftp.knmi.nl/pub_weerberichten/weeroverzicht.xml';
    }

    public function getData()
    {
        $unparsed = file_get_contents($this->source);
        if (empty($unparsed)) {
            return false;
        }
        $parsed = simplexml_load_string($unparsed);
        return $this->toMessage($parsed);
    }

    private function toMessage($data)
    {
        $shortMsg = $data->data->location->block[1]->field_content->__toString();
        $longMsg = $data->data->location->block[2]->field_content->__toString();
        return new PresentMessage($shortMsg, $longMsg);
    }

}
 