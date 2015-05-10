<?php

namespace Importing;


use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlImporter implements Importer {

    public function __construct($yamlFile)
    {
        $this->yamlFile = $yamlFile;
    }

    public function getData() {
        $yamlContents = file_get_contents($this->yamlFile);
        if (empty($yamlContents)) {
            return false;
        }
        try {
            $yamlScenarios = Yaml::parse($yamlContents);
        } catch (ParseException $e) {
            return false;
        }
        return $yamlScenarios;
    }

} 