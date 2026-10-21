<?php

$request = $_SERVER['REQUEST_URI'];
$url = parse_url($request);
preg_match('@:([^/]+)@', $url['path'], $matches);
if ($request == '/__diagnostic') {
    require(__DIR__ . '/diagnostic.php');
} elseif (empty($matches[1])) {
    header("Location: https://portals.veracross.com/groton{$request}");
} else {
    [, $var] = $matches;
    require(__DIR__ . '/disambiguation/index.php');
}
