<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$handler = function (Psr\Http\Message\ServerRequestInterface $request) use ($loop) {
    if ($request->getUri()->getPath() === '/') {
        $phpinfo = "NULL";
        
        $html = <<<HTML
<html>
<head>
<script>
var live = new EventSource("/live");
live.addEventListener("message", function (message) {
    document.body.innerHTML += message.data;
});
</script>
</head>
<body style="background-color:#ddd;">
Hello World at
</body>
</html>
HTML;

        return new React\Http\Response(
            200,
            [
                'Content-Type' => 'text/html'
            ],
            $html
        );
    }

    if ($request->getUri()->getPath() === '/live') {
        $stream = new React\Stream\ThroughStream(function ($data) {
            return 'data: ' . $data . "\n\n";
        });

        $loop->addPeriodicTimer(1.0, function () use ($stream) {
            $stream->write(microtime(true) . "<br>Hello World at ");
        });

        return new React\Http\Response(
            200,
            [
                'Content-Type' => 'text/event-stream',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Headers' => '*'
            ],
            $stream
        );
    }

    return new React\Http\Response(404);
};

$http = new React\Http\Server($handler);

$server = new React\Socket\Server('0.0.0.0:8080', $loop);
$http->listen($server);

$loop->run();
