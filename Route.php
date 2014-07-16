<?php

class Route {

    private $name;
    private $distance;
    private $minimumAltitude;
    private $maximumAltitude;
    private $startLatitude;
    private $startLongitude;
    private $finishLatitude;
    private $finishLongitude;

    function __construct($route = array()) {
        $this->fromArray($route);
    }

    public function fromArray($route) {

        if (array_key_exists('name', $route)) {
            $this->setName($route['name']);
        }

        if (array_key_exists('distance', $route)) {
            $this->setDistance($route['distance']);
        }

    }

    public function getName() {
    }

    public function getDistance() {
    }

    public function getMinimumAltitude() {
    }

    public function getMaximumAltitude() {
    }

    public function getStartLatitude() {
    }

    public function getStartLongitude() {
    }

    public function getFinishLatitude() {
    }

    public function getFinishLongitude() {
    }

    public function __toString() {
    }
}