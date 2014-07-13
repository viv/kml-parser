<?php
require_once('MotionX.php');


class RideGenerator {

    private $rideFile;

    public function __construct($rideFile) {
        $this->setRideFile($rideFile);
    }

    public function setRideFile($file) {
        $this->rideFile = $file;
    }

    private function getXml($file) {
        $zip = new ZipArchive;

        if ($zip->open($file) === TRUE) {
            $contents = $zip->getFromIndex(0);
            $zip->close();
            if ($contents) {
                return simplexml_load_string($contents);
            }
        } else {
            echo "Failed to open {$this->rideFile}";
        }
    }

    public function generateRide() {
        echo new MotionX($this->getXml($this->rideFile));
    }
}