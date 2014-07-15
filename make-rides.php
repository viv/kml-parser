<?php
require_once('Parser.php');

$file = 'test/data/ride-one.kmz';

$parser = new Parser($file);
$parser->getRide();
$parser->getRoute();