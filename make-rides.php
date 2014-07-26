<?php
require_once('Parser.php');
require_once('vendor/autoload.php');
use Symfony\Component\Yaml\Yaml;

$yamlFile = 'rides.yml';

$rides = array();

$kmzWatchDir = "test/data/";

$kmzDir = new DirectoryIterator($kmzWatchDir);
foreach ($kmzDir as $fileinfo) {
    if ($fileinfo->getExtension() === 'kmz') {
        echo "Processing " . $fileinfo->getFilename() . PHP_EOL;
        $parser = new Parser($fileinfo->getRealPath());
        $rides[] = $parser->getRide();
    }
}

$yaml = Yaml::dump($rides, 3);
echo "Ride data appended to {$yamlFile}" . PHP_EOL;

file_put_contents($yamlFile, $yaml, FILE_APPEND);

// Move KMZ into folder for map to pick up
// generate map code