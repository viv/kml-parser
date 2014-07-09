<?php
$file = 'test/data/ride-one.kmz';

$zip = new ZipArchive;

if ($zip->open($file) === TRUE) {
  $contents = $zip->getFromIndex(0);
  if ($contents) {
    $xml = simplexml_load_string($contents);
    echo $xml->Document->name . PHP_EOL;

    foreach ($xml->Document->Placemark as $placemark) {
      if ($placemark->styleUrl == '#fpTrackStyle') {
        foreach ($placemark->description->div->div->table->tr as $row) {
          var_dump($row);
        }
      }
      echo $placemark->styleUrl . PHP_EOL;
    }

    $xml->registerXPathNamespace('kml', 'http://earth.google.com/kml/2.2');
    var_dump($xml->xpath('//kml:description'));
  }

  $zip->close();
} else {
  echo "Failed to open {$file}";
}
