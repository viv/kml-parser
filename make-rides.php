<?php
require_once('Parser.php');
require_once('vendor/autoload.php');
use Symfony\Component\Yaml\Yaml;

$yamlFile = 'rides.yml';

$rides = array();

$kmzWatchDir = "test/data/";
$kmzDestDir = "rides/data/";

$kmzDir = new DirectoryIterator($kmzWatchDir);
foreach ($kmzDir as $fileinfo) {
    if ($fileinfo->getExtension() === 'kmz') {
        echo "Processing " . $fileinfo->getFilename() . PHP_EOL;
        $parser = new Parser($fileinfo->getRealPath());

        $top = 51.545425;
        $right = -3.568107;
        $bottom = 51.539727;
        $left = -3.57891;

        $parser->geoFence($top, $right, $bottom, $left);

        $rides[] = $parser->getRide();

        // Move KMZ into folder for map to pick up
        echo "Moving " . $fileinfo->getFilename() . " to {$kmzDestDir}" . PHP_EOL;
        rename($fileinfo->getRealPath(), $kmzDestDir . $fileinfo->getFilename());
    }
}

$yaml = Yaml::dump($rides, 3);
echo "Ride data appended to {$yamlFile}" . PHP_EOL;

file_put_contents($yamlFile, $yaml, FILE_APPEND);



// generate map code