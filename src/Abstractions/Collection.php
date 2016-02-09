<?php

namespace Abstractions;

use Interfaces\DataBlock;

abstract class Collection
{
    protected $dataBlocks;

    public function __construct()
    {
        $this->dataBlocks = [];
    }

    public function add(DataBlock $dataBlock)
    {
        $this->dataBlocks[] = $dataBlock;
    }

    public function addByKeyValue($key, DataBlock $dataBlock)
    {
        if (isset($this->dataBlocks[$key])) {
            throw new \RuntimeException('Duplicate keys found');
        }
        $this->dataBlocks[$key] = $dataBlock;
    }

    public function getDataBlocks()
    {
        return $this->dataBlocks;
    }
} 