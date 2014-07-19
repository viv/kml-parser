<?php
require_once('MotionX.php');
require_once('Ride.php');
require_once('Route.php');

/**
 * Parse KML
 */
class Parser {

    private $sourceFile;
    private $xml;

    public function __construct($sourceFile) {
        $this->setSourceFile($sourceFile);
    }

    public function setSourceFile($sourceFile) {
        $this->sourceFile = $sourceFile;
    }

    private function getXml() {
        if (!$this->xml) {
            $this->setXml();
        }
        return $this->xml;
    }

    private function setXml() {
        $this->xml = simplexml_load_string($this->readFromKmz());     
    }

    private function readFromKmz() {
        $contents = null;
        $zip = new ZipArchive;
        if ($zip->open($this->sourceFile) === TRUE) {
            $contents = $zip->getFromIndex(0);
            $zip->close();
        }
        return $contents;
    }

    public function getRide() {
        $rideDetails = new MotionX($this->getXml());
        $ride = new Ride($rideDetails->toArray());
        return $ride;
    }

    public function getRoute() {
        $rideDetails = new MotionX($this->getXml());
        $route = new Route($rideDetails->toArray());
        return $route;
    }
}