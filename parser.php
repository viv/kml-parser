<?php
require_once('motionx.php');

$file = 'test/data/ride-one.kmz';

$xml = getXml($file);

$motionX = new MotionX($xml);

echo $motionX->getTrackName() . PHP_EOL;

echo $motionX->getTrackDate() . PHP_EOL;
echo $motionX->getDistance() . PHP_EOL;
echo $motionX->getElapsedTime() . PHP_EOL;
echo $motionX->getAverageSpeed() . PHP_EOL;
echo $motionX->getMaxSpeed() . PHP_EOL;
echo $motionX->getAveragePace() . PHP_EOL;
echo $motionX->getMinAltitude() . PHP_EOL;
echo $motionX->getMaxAltitude() . PHP_EOL;
echo $motionX->getStartTime() . PHP_EOL;
echo $motionX->getStartLatitude() . PHP_EOL;
echo $motionX->getStartLongitude() . PHP_EOL;
echo $motionX->getFinishTime() . PHP_EOL;
echo $motionX->getFinishLatitude() . PHP_EOL;
echo $motionX->getFinishLongitude() . PHP_EOL;

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
