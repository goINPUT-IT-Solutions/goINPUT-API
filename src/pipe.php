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
require_once __DIR__ . '/../config.php';

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
