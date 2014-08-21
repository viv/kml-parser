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
        return (string) $this->xml->Document->name;
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
        // TODO limit max?
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
        // TODO convert date format
        return strip_tags($this->getTrackDescription()->div->div->table[1]->tr[0]->td[1]->asXML());
    }

    public function getStartLatitude() {
        return strip_tags($this->getTrackDescription()->div->div->table[1]->tr[2]->td[1]->asXML());
    }

    public function getStartLongitude() {
        return strip_tags($this->getTrackDescription()->div->div->table[1]->tr[3]->td[1]->asXML());
    }

    public function getFinishTime() {
        // TODO convert date format
        return strip_tags($this->getTrackDescription()->div->div->table[2]->tr[0]->td[1]->asXML());
    }

    public function getFinishLatitude() {
        return strip_tags($this->getTrackDescription()->div->div->table[2]->tr[2]->td[1]->asXML());
    }

    public function getFinishLongitude() {
        return strip_tags($this->getTrackDescription()->div->div->table[2]->tr[3]->td[1]->asXML());
    }

    public function toArray() {
        $result = array(
            'name' => $this->getTrackName(),
            'date' => $this->getTrackDate(),
            'distance' => $this->getDistance(),
            'duration' => $this->getElapsedTime(),
            'averageSpeed' => $this->getAverageSpeed(),
            'maximumSpeed' => $this->getMaxSpeed(),
            'averagePace' => $this->getAveragePace(),
            'minimumAltitude' => $this->getMinAltitude(),
            'maximumAltitude' => $this->getMaxAltitude(),
            'startTime' => $this->getStartTime(),
            'finishTime' => $this->getFinishTime(),
        );
        return $result;
    }

    public function __toString() {
        return print_r($this->toArray(), true);
    }
}