<?php
/*
 *             _____ _   _ _____  _    _ _______
 *            |_   _| \ | |  __ \| |  | |__   __|
 *   __ _  ___  | | |  \| | |__) | |  | |  | |
 *  / _` |/ _ \ | | | . ` |  ___/| |  | |  | |
 * | (_| | (_) || |_| |\  | |    | |__| |  | |
 *  \__, |\___/_____|_| \_|_|     \____/   |_|
 *   __/ |
 *  |___/
 *
 *  Copyright (c) goINPUT IT Solutions 2022.
 */

require __DIR__ . '/../vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$browser = new Clue\React\Buzz\Browser($loop);
$packagist = new Clue\React\Packagist\Api\Client($browser);

$packagist->search('reactphp')->then(function ($info) {
    var_dump($info);
});

$loop->run();
