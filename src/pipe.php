<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$stream = new React\Stream\WritableResourceStream(STDOUT, $loop);
$stream->write('hello');

$stdin = new React\Stream\ReadableResourceStream(STDIN, $loop);
// $stdin->on('data', function ($data) use ($stream) {
//     $stream->write(strtoupper($data));
// });
// $stdin->on('end', function () {
//     echo 'DONE';
// });

$dummy = new React\Stream\ThroughStream(function ($data) {
    return '[' . $data . ']';
});

$stdin->pipe($dummy)->pipe($stream);

$loop->run();
