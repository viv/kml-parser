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

    function __construct(array $route) {
        if (!empty($route)) {
            $this->name = $route['name'];
            $this->distance = $route['distance'];
            $this->minimumAltitude = $route['minimumAltitude'];
            $this->maximumAltitude = $route['maximumAltitude'];
            $this->startLatitude = $route['startLatitude'];
            $this->startLongitude = $route['startLongitude'];
            $this->finishLatitude = $route['finishLatitude'];
            $this->finishLongitude = $route['finishLongitude'];
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getDistance() {
        return $this->distance;
    }

    public function getMinimumAltitude() {
        return $this->minimumAltitude;
    }

    public function getMaximumAltitude() {
        return $this->maximumAltitude;
    }

    public function getStartLatitude() {
        return $this->startLatitude;
    }

    public function getStartLongitude() {
        return $this->startLongitude;
    }

    public function getFinishLatitude() {
        return $this->finishLatitude;
    }

    public function getFinishLongitude() {
        return $this->finishLongitude;
    }

    public function __toString() {
    }
}