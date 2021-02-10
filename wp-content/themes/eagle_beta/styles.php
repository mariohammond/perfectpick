<?php

// Set Expiration (Seconds, Minutes, Hours, Days)
$expires = 60*60*24*1;
header("Pragma: public");
header("Cache-Control: max-age=" . $expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');

$files = array(
	"style.css",
	"css/desktop.css",
	"css/tablet.css",
	"css/mobile.css",
);

header("Content-Type: text/css");

foreach ($files as $file) {
    if (strstr($file, "http")) {
	    echo "\n\n/********** --- $file --- **********/\n\n";
	    echo file_get_contents($file);
    }
    else {
	    echo "\n\n/********** --- $file --- **********/\n\n";
	    echo file_get_contents($file);
    }
}

?>
