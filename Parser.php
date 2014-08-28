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
        $this->fenceStart($top, $right, $bottom, $left);
        $this->fenceEnd($top, $right, $bottom, $left);

        echo "Fencing track" . PHP_EOL;
        $coordinates = $this->getCoordinates();
        $outsideFence = "";
        $insideFence = 0;
        foreach($coordinates as $line){
            if (!empty($line)) {
                list($long, $lat, $alt) = explode(',', $line);

                settype($long, "float");
                settype($lat, "float");
                settype($alt, "float");

                if ($long < $right && $long > $left
                    && $lat < $top && $lat > $bottom) {
                    $insideFence++;
                } else {
                    $outsideFence .= "{$long}, {$lat}, {$alt}" . PHP_EOL;
                }
            }
        }

        echo "Fenced {$insideFence} coordinates" . PHP_EOL;
        $this->setCoordinates($outsideFence);
        $this->saveKmz();
    }

    private function fenceStart($top, $right, $bottom, $left) {
        $startPlacemark = $this->getStartPlacemark();
        $startCoordinates = $startPlacemark->getElementsByTagName('coordinates')->item(0)->nodeValue;
        if (!empty($startCoordinates)) {
            list($long, $lat, $alt) = explode(',', $startCoordinates);

            settype($long, "float");
            settype($lat, "float");
            settype($alt, "float");

            if ($long < $right && $long > $left
                && $lat < $top && $lat > $bottom) {
                echo "Removing start node: {$startCoordinates}" . PHP_EOL;
                $this->removeStartPlacemark();
            } else {
                echo "Leave start node as is: {$startCoordinates}" . PHP_EOL;
            }
        }
    }

    private function fenceEnd($top, $right, $bottom, $left) {
        $endPlacemark = $this->getEndPlacemark();
        $endCoordinates = $endPlacemark->getElementsByTagName('coordinates')->item(0)->nodeValue;
        if (!empty($endCoordinates)) {
            list($long, $lat, $alt) = explode(',', $endCoordinates);

            settype($long, "float");
            settype($lat, "float");
            settype($alt, "float");

            if ($long < $right && $long > $left
                && $lat < $top && $lat > $bottom) {
                echo "Removing end node: {$endCoordinates}" . PHP_EOL;
                $this->removeEndPlacemark();
            } else {
                echo "Leave end node as is: {$endCoordinates}" . PHP_EOL;
            }
        }
    }

    private function getCoordinates() {
        $xml = $this->getXml();
        $ls = $xml->getElementsByTagName('LineString')->item(0);
        $coordinates = $ls->getElementsByTagName('coordinates')->item(0)->nodeValue;
        return $this->linesToArray($coordinates);
    }

    private function setCoordinates($coordinates) {
        $xml = $this->getXml();
        $ls = $xml->getElementsByTagName('Placemark')->item(0);
        $ls->getElementsByTagName('coordinates')->item(0)->nodeValue = $coordinates;
    }

    private function getStartPlacemark() {
        $xml = $this->getXml();
        $placemarks = $xml->getElementsByTagName('Placemark');
        foreach ($placemarks as $placemark) {
            $name = $placemark->getElementsByTagName('name')->item(0)->nodeValue;
            if ($name == "Start") {
                return $placemark;
            }
        }
    }

    private function getEndPlacemark() {
        $xml = $this->getXml();
        $placemarks = $xml->getElementsByTagName('Placemark');
        foreach ($placemarks as $placemark) {
            $name = $placemark->getElementsByTagName('name')->item(0)->nodeValue;
            if ($name == "End") {
                return $placemark;
            }
        }
    }

    private function removeStartPlacemark() {
        $placemark = $this->getStartPlacemark();
        $placemark->parentNode->removeChild($placemark);
    }

    private function removeEndPlacemark() {
        $placemark = $this->getEndPlacemark();
        $placemark->parentNode->removeChild($placemark);
    }

    private function linesToArray($string) {
        return preg_split("/((\r?\n)|(\r\n?))/", $string);
    }

    public function getRide() {
        $ride = new MotionX(simplexml_import_dom($this->getXml()));
        return $ride->toArray();
    }
}