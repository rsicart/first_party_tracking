<?php

if (!$_GET['advertiser'])
    exit(1);

// url setup
$urls = [
    'root' => 'http://tracker.local',
    'click' => 'http://tracker.local/click.php',
    'trackImpression' => 'http://tracker.local/event.php?type=impression',
];

// creative setup
$advertisers = [
    'a' => [
        'image' => $urls['root'] .'/banner_advertisera.gif', 
        'url' => 'http://advertisera.local',
    ],
    'b' => [
        'image' => $urls['root'] .'/banner_advertiserb.jpg', 
        'url' => 'http://advertiserb.local',
    ],
];


// setup navId
if ($_COOKIE && $_COOKIE['navId'] != '') {
    // get from 3rd party
    $navId = $_COOKIE['navId'];
} elseif (isset($_GET['navId']) && $_GET['navId'] != '') {
    // 1st party
    $navId = $_GET['navId'];
} else {
    // not found, new one
    $navId = uniqid();
}


// set 3rd party cookie
setcookie("navId", $navId);


// tag setup
$tag = <<<EOT
    var navId = '{$navId}';
    var cb = Math.random().toString().substr(2);

    // set 1st party cookie
    document.cookie = 'navId=' + navId;

    // show tag
    var targetUrl = encodeURIComponent('{$advertisers[$_GET['advertiser']]['url']}' + '?navId=' + navId);
    document.write('<a href="{$urls['click']}?go=' + targetUrl +'"><img src="{$advertisers[$_GET['advertiser']]['image']}" /></a>');
    document.write('<img src="{$urls['trackImpression']}&navId=' + navId + '&cb=' + cb + '" />');
EOT;

print($tag);
