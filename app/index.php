<?php

$request = $_SERVER['REQUEST_URI'];
$url = parse_url($request);
preg_match('@:([^/]+)@', $url['path'], $matches);
[, $var] = $matches;
if ($request == '/__diagnostic') {
    require(__DIR__ . '/diagnostic.php');
} elseif (empty($var)) {
    header("Location: https://portals.veracross.com/groton{$request}");
} else {
    require(__DIR__ . '/disambiguator.php');
}
