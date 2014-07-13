<?php

class MotionX
{
    private $xml;

    function __construct($xml) {
        $this->setXml($xml);
    }

    public function setXml($xml) {
        $this->xml = $xml;
    }

    public function getTrackName() {
        return $this->xml->Document->name;
    }

    public function getTrackDescription() {
        $this->xml->registerXPathNamespace('kml', 'http://earth.google.com/kml/2.2');
        return $this->xml->xpath('//kml:description')[0];
    }

    public function getTrackDate() {
        return strip_tags($this->getTrackDescription()->div->div->table->tr->td[1]->asXML());
    }

    public function getDistance() {
        return strip_tags($this->getTrackDescription()->div->div->table->tr[1]->td[1]->asXML());
    }

    public function getElapsedTime() {
        return strip_tags($this->getTrackDescription()->div->div->table->tr[2]->td[1]->asXML());
    }

    public function getAverageSpeed() {
        return strip_tags($this->getTrackDescription()->div->div->table->tr[3]->td[1]->asXML());
    }

    public function getMaxSpeed() {
        return strip_tags($this->getTrackDescription()->div->div->table->tr[4]->td[1]->asXML());
    }

    public function getAveragePace() {
        return strip_tags($this->getTrackDescription()->div->div->table->tr[5]->td[1]->asXML());
    }

    public function getMinAltitude() {
        return strip_tags($this->getTrackDescription()->div->div->table->tr[6]->td[1]->asXML());
    }

    public function getMaxAltitude() {
        return strip_tags($this->getTrackDescription()->div->div->table->tr[7]->td[1]->asXML());
    }

    public function getStartTime() {
        return strip_tags($this->getTrackDescription()->div->div->table[1]->tr[0]->td[1]->asXML());
    }

    public function getStartLatitude() {
        return strip_tags($this->getTrackDescription()->div->div->table[1]->tr[2]->td[1]->asXML());
    }

    public function getStartLongitude() {
        return strip_tags($this->getTrackDescription()->div->div->table[1]->tr[3]->td[1]->asXML());
    }

    public function getFinishTime() {
        return strip_tags($this->getTrackDescription()->div->div->table[2]->tr[0]->td[1]->asXML());
    }

    public function getFinishLatitude() {
        return strip_tags($this->getTrackDescription()->div->div->table[2]->tr[2]->td[1]->asXML());
    }

    public function getFinishLongitude() {
        return strip_tags($this->getTrackDescription()->div->div->table[2]->tr[3]->td[1]->asXML());
    }

    public function __toString() {
        $out = $this->getTrackName() . PHP_EOL;
        $out .= $this->getTrackDate() . PHP_EOL;
        $out .= $this->getDistance() . PHP_EOL;
        $out .= $this->getElapsedTime() . PHP_EOL;
        $out .= $this->getAverageSpeed() . PHP_EOL;
        $out .= $this->getMaxSpeed() . PHP_EOL;
        $out .= $this->getAveragePace() . PHP_EOL;
        $out .= $this->getMinAltitude() . PHP_EOL;
        $out .= $this->getMaxAltitude() . PHP_EOL;
        $out .= $this->getStartTime() . PHP_EOL;
        $out .= $this->getStartLatitude() . PHP_EOL;
        $out .= $this->getStartLongitude() . PHP_EOL;
        $out .= $this->getFinishTime() . PHP_EOL;
        $out .= $this->getFinishLatitude() . PHP_EOL;
        $out .= $this->getFinishLongitude() . PHP_EOL;
        return $out;
    }
}