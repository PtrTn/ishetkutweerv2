<?php

namespace Location;

class StationFactory
{
    private $stations;

    public function __construct()
    {
        $this->stations = [];
        $this->initStations();
    }

    public function getStations()
    {
        return $this->stations;
    }

    private function initStations()
    {
        $this->addStation(new Station(
            391,
            6391,
            'Arcen',
            51.498,
            6.197
        ));
        $this->addStation(new Station(
            249,
            6249,
            'Berkhout',
            52.644,
            4.979
        ));
        $this->addStation(new Station(
            260,
            6260,
            'De Bilt',
            52.100,
            5.180
        ));
        $this->addStation(new Station(
            370,
            6370,
            'Eindhoven',
            51.451,
            5.377
        ));
        $this->addStation(new Station(
            377,
            6377,
            'Ell',
            51.198,
            5.763
        ));
        $this->addStation(new Station(
            350,
            6350,
            'Gilze Rijen',
            51.566,
            4.936
        ));
        $this->addStation(new Station(
            283,
            6283,
            'Groenlo-Hupsel',
            52.069,
            6.657
        ));
        $this->addStation(new Station(
            278,
            6278,
            'Heino',
            52.435,
            6.259
        ));
        $this->addStation(new Station(
            356,
            6356,
            'Herwijnen',
            51.859,
            5.146
        ));
        $this->addStation(new Station(
            330,
            6330,
            'Hoek van Holland',
            51.992,
            4.122
        ));
        $this->addStation(new Station(
            279,
            6279,
            'Hoogeveen',
            52.750,
            6.574
        ));
        $this->addStation(new Station(
            225,
            6225,
            'IJmuiden',
            52.463,
            4.555
        ));
        $this->addStation(new Station(
            277,
            6277,
            'Lauwersoog',
            53.413,
            6.200
        ));
        $this->addStation(new Station(
            270,
            6270,
            'Leeuwarden',
            53.224,
            5.752
        ));
        $this->addStation(new Station(
            269,
            6269,
            'Lelystad',
            52.458,
            5.520
        ));
        $this->addStation(new Station(
            348,
            6348,
            'Lopik-Cabauw',
            51.970,
            4.926
        ));
        $this->addStation(new Station(
            380,
            6380,
            'Maastricht',
            50.906,
            5.762
        ));
        $this->addStation(new Station(
            273,
            6273,
            'Marknesse',
            53.703,
            5.888
        ));
        $this->addStation(new Station(
            286,
            6286,
            'Nieuw Beerta',
            53.196,
            7.150
        ));
        $this->addStation(new Station(
            344,
            6344,
            'Rotterdam',
            51.962,
            4.447
        ));
        $this->addStation(new Station(
            240,
            6240,
            'Schiphol',
            52.318,
            4.790
        ));
        $this->addStation(new Station(
            267,
            6267,
            'Stavoren',
            52.898,
            5.384
        ));
        $this->addStation(new Station(
            251,
            6251,
            'Terschelling',
            53.392,
            5.346
        ));
        $this->addStation(new Station(
            290,
            6290,
            'Twente',
            52.274,
            6.891
        ));
        $this->addStation(new Station(
            375,
            6375,
            'Volkel',
            51.659,
            5.707
        ));
        $this->addStation(new Station(
            215,
            6215,
            'Voorschoten',
            52.141,
            4.437
        ));
        $this->addStation(new Station(
            242,
            6242,
            'Vlieland',
            53.241,
            4.921
        ));
        $this->addStation(new Station(
            310,
            6310,
            'Vlissingen',
            51.442,
            3.596
        ));
        $this->addStation(new Station(
            319,
            6319,
            'Westdorpe',
            51.226,
            3.861
        ));
        $this->addStation(new Station(
            257,
            6257,
            'Wijk aan Zee',
            52.506,
            4.603
        ));
        $this->addStation(new Station(
            340,
            6340,
            'Woensdrecht',
            51.449,
            4.342
        ));
    }

    private function addStation(Station $station)
    {
        $this->stations[] = $station;
    }

}
 