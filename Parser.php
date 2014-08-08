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
        $this->xml = new DOMDocument();
        $this->xml->loadXML($this->readFromKmz());
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

    private function saveKmz() {
        $zip = new ZipArchive;
        if ($zip->open($this->sourceFile, ZipArchive::CREATE) === TRUE) {
            $zip->addFromString('doc.kml', $this->getXml()->saveXml());
            $zip->close();
        }
    }

    public function geoFence($top, $right, $bottom, $left) {
        $coordinates = $this->getCoordinates();
        $geoFenced = "";
        foreach($coordinates as $line){
            if (!empty($line)) {
                list($long, $lat, $alt) = explode(',', $line);

                settype($long, "float");
                settype($lat, "float");
                settype($alt, "float");

                if ($long < $right && $long > $left
                    && $lat < $top && $lat > $bottom) {
                    // echo "In range: {$line}" . PHP_EOL;
                } else {
                    $geoFenced .= "{$long}, {$lat}, {$alt}" . PHP_EOL;
                }
            }
        }

        $this->setCoordinates($geoFenced);
        $this->fenceStart($top, $right, $bottom, $left);
        $this->fenceFinish($top, $right, $bottom, $left);
    }

    private function fenceStart($top, $right, $bottom, $left) {
        $startCoordinates = $this->getStartCoordinates();
        if (!empty($startCoordinates)) {
            list($long, $lat, $alt) = explode(',', $startCoordinates);

            settype($long, "float");
            settype($lat, "float");
            settype($alt, "float");

            if ($long < $right && $long > $left
                && $lat < $top && $lat > $bottom) {
                echo "Remove XML node $long $lat $alt" . PHP_EOL;
            } else {
                echo "Leave node as is";
            }
        }
        // Save nodes
    }
    
    private function fenceFinish($top, $right, $bottom, $left) {
        $finishCoordinates = $this->getFinishCoordinates();
        if (!empty($finishCoordinates)) {
            list($long, $lat, $alt) = explode(',', $finishCoordinates);

            settype($long, "float");
            settype($lat, "float");
            settype($alt, "float");

            if ($long < $right && $long > $left
                && $lat < $top && $lat > $bottom) {
                echo "Remove XML node $long $lat $alt" . PHP_EOL;
            } else {
                echo "Leave node as is";
            }
        }
        // Save nodes
    }

    private function getCoordinates() {
        $xml = $this->getXml();
        $ls = $xml->getElementsByTagName('LineString')->item(0);
        $coordinates = $ls->getElementsByTagName('coordinates')->item(0)->nodeValue;
        return $this->linesToArray($coordinates);
    }

    private function setCoordinates($coordinates) {
        $xml = $this->getXml();
        $ls = $xml->getElementsByTagName('LineString')->item(0);
        $ls->getElementsByTagName('coordinates')->item(0)->nodeValue = $coordinates;
        $this->saveKmz();
    }

    private function getStartCoordinates() {
        $xml = $this->getXml();
        $point = $xml->getElementsByTagName('Point')->item(0);
        return $point->getElementsByTagName('coordinates')->item(0)->nodeValue;
    }

    private function getFinishCoordinates() {
        $xml = $this->getXml();
        $point = $xml->getElementsByTagName('Point')->item(1);
        return $point->getElementsByTagName('coordinates')->item(0)->nodeValue;
    }

    private function linesToArray($string) {
        return preg_split("/((\r?\n)|(\r\n?))/", $string);
    }

    public function getRide() {
        $ride = new MotionX(simplexml_import_dom($this->getXml()));
        return $ride->toArray();
    }
}