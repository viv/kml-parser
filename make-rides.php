<?php
require_once('Parser.php');

$file = 'test/data/ride-one.kmz';

$parser = new Parser($file);
var_dump($parser->getRide());
var_dump($parser->getRoute());