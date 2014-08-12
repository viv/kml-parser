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
    }
}

