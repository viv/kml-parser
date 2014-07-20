<?php
require_once('Parser.php');
require_once 'vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

$kmzFile = 'test/data/ride-one.kmz';
$yamlFile = 'rides.yml';

$parser = new Parser($kmzFile);
var_dump($parser->getRide());

$yaml = Yaml::dump(array(array('ride' => $parser->getRide())), 3);
echo $yaml;

file_put_contents($yamlFile, $yaml, FILE_APPEND);