<?php

// setup
$allowed = ['impression', 'click', 'lead',];
$logFile = '/srv/shared/tmp/events.log';

if (empty($_GET['type']) || !in_array($_GET['type'], $allowed)) {
    throw new Exception('Event type is mandatory.');
    exit(1);
}

// get navId
$source = 'unknown';
if (!empty($_COOKIE['navId'])) {
    $navIds = explode(',', $_COOKIE['navId']);
    $source = 'cookie3rd';
} elseif (!empty($_GET['navId'])) {
    $navIds = explode(',', $_GET['navId']);
    $source = 'cookie1st';
} else {
    throw new Exception('Event navId is mandatory.');
    exit(1);
}



// log event
$data = [
    'ts' => time(),
    'type' => $_GET['type'],
    'navIds' => $navIds,
    'source' => $source,
    'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
];
file_put_contents($logFile, json_encode($data) . "\n", FILE_APPEND);
