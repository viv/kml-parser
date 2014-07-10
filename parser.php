<?php
$file = 'test/data/ride-one.kmz';

$xml = getXml($file);

echo getTrackName($xml) . PHP_EOL;
echo getTrackDate($xml) . PHP_EOL;
echo getDistance($xml) . PHP_EOL;
echo getElapsedTime($xml) . PHP_EOL;

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

function getMaxSpeed($xml) {
    return $xml->Document->name;
}

function getAverageSpeed($xml) {
    return $xml->Document->name;
}

function getAveragePace($xml) {
    return $xml->Document->name;
}

function getMinAltitude($xml) {
    return $xml->Document->name;
}

function getMaxAltitude($xml) {
    return $xml->Document->name;
}

function getStartLocation($xml) {
    return $xml->Document->name;
}

function getFinishLocation($xml) {
    return $xml->Document->name;
}

function getStartTime($xml) {
    return $xml->Document->name;
}

function getFinishTime($xml) {
    return $xml->Document->name;
}