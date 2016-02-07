<?php

namespace AbstractClasses;


use Interfaces\DataBlock;

abstract class Collection
{
    protected $collection;

    public function __construct()
    {
        $this->collection = [];
    }

    public function add(DataBlock $dataBlock)
    {
        $this->collection[] = $dataBlock;
    }
} 