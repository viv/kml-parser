<?php
$file = 'test/data/ride-one.kmz';

$xml = getXml($file);

echo getTrackName($xml) . PHP_EOL;

echo getTrackDate($xml) . PHP_EOL;
echo getDistance($xml) . PHP_EOL;
echo getElapsedTime($xml) . PHP_EOL;
echo getAverageSpeed($xml) . PHP_EOL;
echo getMaxSpeed($xml) . PHP_EOL;
echo getAveragePace($xml) . PHP_EOL;
echo getMinAltitude($xml) . PHP_EOL;
echo getMaxAltitude($xml) . PHP_EOL;
echo getStartTime($xml) . PHP_EOL;
echo getStartLatitude($xml) . PHP_EOL;
echo getStartLongitude($xml) . PHP_EOL;
echo getFinishTime($xml) . PHP_EOL;
echo getFinishLatitude($xml) . PHP_EOL;
echo getFinishLongitude($xml) . PHP_EOL;

function getXml($file) {
    $zip = new ZipArchive;

    if ($zip->open($file) === TRUE) {
        $contents = $zip->getFromIndex(0);
        $zip->close();
        if ($contents) {
            return simplexml_load_string($contents);
        }
    } else {
        echo "Failed to open {$file}";
    }
}

function getTrackName($xml) {
    return $xml->Document->name;
}

function getTrackDescription($xml) {
    $xml->registerXPathNamespace('kml', 'http://earth.google.com/kml/2.2');
    return $xml->xpath('//kml:description')[0];
}

function getTrackDate($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table->tr->td[1]->asXML());
}

function getDistance($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table->tr[1]->td[1]->asXML());
}

function getElapsedTime($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table->tr[2]->td[1]->asXML());
}

function getAverageSpeed($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table->tr[3]->td[1]->asXML());
}

function getMaxSpeed($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table->tr[4]->td[1]->asXML());
}

function getAveragePace($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table->tr[5]->td[1]->asXML());
}

function getMinAltitude($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table->tr[6]->td[1]->asXML());
}

function getMaxAltitude($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table->tr[7]->td[1]->asXML());
}

function getStartTime($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table[1]->tr[0]->td[1]->asXML());
}

function getStartLatitude($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table[1]->tr[2]->td[1]->asXML());
}

function getStartLongitude($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table[1]->tr[3]->td[1]->asXML());
}

function getFinishTime($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table[2]->tr[0]->td[1]->asXML());
}

function getFinishLatitude($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table[2]->tr[2]->td[1]->asXML());
}

function getFinishLongitude($xml) {
    return strip_tags(getTrackDescription($xml)->div->div->table[2]->tr[3]->td[1]->asXML());
}