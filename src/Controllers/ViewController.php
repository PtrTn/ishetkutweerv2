<?php

namespace Controllers;

use Location\LocationDataBlock;
use Silex\Application;
use Station\Station;

class ViewController
{
    private $twig;
    private $dataController;

    public function __construct(\Twig_Environment $twig, DataController $dataController)
    {
        $this->twig = $twig;
        $this->dataController = $dataController;
    }

    public function getView(Station $station, LocationDataBlock $location)
    {
        // Load data required for view
        $data = $this->dataController->getDataArray($station, $location);

        // Load view
        return $this->twig->render('home.twig', $data);
    }
}
 