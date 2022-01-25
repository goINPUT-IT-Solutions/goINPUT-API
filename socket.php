<?php

require __DIR__ . '/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$connector = new React\Socket\Connector($loop);

for ($i = 0; $i < 10; ++$i) {
    $connector->connect('www.google.com:80')->then(function (React\Socket\ConnectionInterface $http) {
        $http->write("GET / HTTP/1.0\r\n\r\n");

        $http->on('data', function ($data) {
            echo $data;
        });

        $http->on('close', function () {
            echo 'CLOSED';
        });
    });
}

$loop->run();
