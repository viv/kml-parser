<?php
require_once('MotionX.php');

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
        echo $rideDetails;
    }

    public function getRoute() {
        $rideDetails = new MotionX($this->getXml());
        echo $rideDetails;
    }
}