<?php
require_once('RideGenerator.php');

$file = 'test/data/ride-one.kmz';
$generator = new RideGenerator($file);
$generator->generateRide();