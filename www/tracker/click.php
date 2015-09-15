<?php

if (!$_GET['go'])
    exit(1);

$goUrl = urldecode($_GET['go']);


// get querystring
$tmp = explode('?', $goUrl); 
$qs = $tmp[1];
// get params
$params = explode('&', $qs);
$navId = null;
foreach ($params as $param) {
    list($name, $value) = explode('=', $param);
    if ($name == 'navId' && $value != '') {
        $navId = $value;
        break;
    }
}
if (!$navId) {
    throw new Exception('NavId is mandatory on click redirection to advertiser\'s site.');
    exit(1);
}

// log click event
$trackClickUrl = 'http://tracker.local/event.php?type=click&navId=' . $navId;
file_get_contents($trackClickUrl);

header(sprintf('Location: %s', $goUrl));
