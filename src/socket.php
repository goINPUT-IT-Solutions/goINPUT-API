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

$connector = new React\Socket\Connector($loop);

for ($i = 0; $i < 10; ++$i) {
    $connector->connect('www.google.com:80')->then(function (React\Socket\ConnectionInterface $http) {
        $http->write("GET / HTTP/v1_0\r\n\r\n");

        $http->on('data', function ($data) {
            echo $data;
        });

        $http->on('close', function () {
            echo 'CLOSED';
        });
    });
}

$loop->run();
