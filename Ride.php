<?php

class Ride {

    private $date;
    private $duration;
    private $averageSpeed;
    private $maximumSpeed;
    private $averagePace;
    private $startTime;
    private $finishTime;

    function __construct(array $ride) {
        if (!empty($ride)) {
            $this->date = $ride['date'];
            $this->duration = $ride['duration'];
            $this->averageSpeed = $ride['averageSpeed'];
            $this->maximumSpeed = $ride['maximumSpeed'];
            $this->averagePace = $ride['averagePace'];
            $this->startTime = $ride['startTime'];
            $this->finishTime = $ride['finishTime'];
        }
    }

    public function getDate() {
        return $this->date;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getAverageSpeed() {
        return $this->averageSpeed;
    }

    public function getMaximumSpeed() {
        return $this->maximumSpeed;
    }

    public function getAveragePace() {
        return $this->averagePace;
    }

    public function getStartTime() {
        return $this->startTime;
    }

    public function getFinishTime() {
        return $this->finishTime;
    }

    public function __toString() {
    }
}