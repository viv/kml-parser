<?php
require_once('Parser.php');
require_once('vendor/autoload.php');
use Symfony\Component\Yaml\Yaml;

$yamlFile = 'rides.yml';

$rides = array();

// Loop through files
// Parse and append YAML
// Move KMZ into folder for map to pick up
// generate map code

$kmzFile = 'test/data/ride-one.kmz';

echo "Parsing {$kmzFile}" . PHP_EOL;
$parser = new Parser($kmzFile);
$rides[] = $parser->getRide();

$yaml = Yaml::dump($rides, 3);
echo "Ride data appended to {$yamlFile}" . PHP_EOL;

file_put_contents($yamlFile, $yaml, FILE_APPEND);