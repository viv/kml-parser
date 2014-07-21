<?php
require_once('Parser.php');
require_once('vendor/autoload.php');
use Symfony\Component\Yaml\Yaml;

$kmzFile = 'test/data/ride-one.kmz';
$yamlFile = 'rides.yml';

$rides = array();

echo "Parsing {$kmzFile}" . PHP_EOL;
$parser = new Parser($kmzFile);
$rides[] = $parser->getRide();

$yaml = Yaml::dump($rides, 3);
echo "Ride data appended to {$yamlFile}" . PHP_EOL;

file_put_contents($yamlFile, $yaml, FILE_APPEND);