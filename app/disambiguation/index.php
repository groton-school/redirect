<?php

/** @var array{scheme:string,host:string,port:int,user:string,pass:string,query:string,path:string,fragment:string}|false $url defined in index.php*/
/** @var string $var defined in index.php */

$title = $_GET['title'] ?: 'Disambiguation';
$instructions = $_GET['instructions'] ?: 'Choose one';
$target = $_GET['target'] ?: '_top';

parse_str($url['query'], $query);
unset($query['title']);
unset($query['instructions']);
unset($query['target']);
unset($query[$var]);
unset($query['caption']);
$url['query'] = http_build_query($query);
$request = $url['path'] . (empty($query) ? '' : '?' . $url['query']) . (empty($url['fragment']) ? '' : '#' . $url['fragment']);

if (count($_GET[$var]) > 1) {
    require(__DIR__ . '/picker.php');
} else {
    require(__DIR__ . '/browser_redirect.php');
}
