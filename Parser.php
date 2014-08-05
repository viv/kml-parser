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

    public function geoFence($top, $right, $bottom, $left) {
        $coordinates = $this->getCoordinates();
        foreach($coordinates as $line){
            if (!empty($line)) {
                list($long, $lat, $alt) = explode(',', $line);

                settype($long, "float");
                settype($lat, "float");
                settype($alt, "float");

                if ($long < $right && $long > $left
                    && $lat < $top && $lat > $bottom) {
                    echo "In range: {$line}" . PHP_EOL;
                }
            }
        }
    }

    private function getCoordinates() {
        $xml = $this->getXml();
        $ls = $xml->getElementsByTagName('LineString')->item(0);
        $coordinates = $ls->getElementsByTagName('coordinates')->item(0)->nodeValue;
        return $this->linesToArray($coordinates);
    }

    private function linesToArray($string) {
        return preg_split("/((\r?\n)|(\r\n?))/", $string);
    }

    public function getRide() {
        $ride = new MotionX(simplexml_import_dom($this->getXml()));
        return $ride->toArray();
    }
}