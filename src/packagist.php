<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$browser = new Clue\React\Buzz\Browser($loop);
$packagist = new Clue\React\Packagist\Api\Client($browser);

$packagist->search('reactphp')->then(function ($info) {
    var_dump($info);
});

$loop->run();
