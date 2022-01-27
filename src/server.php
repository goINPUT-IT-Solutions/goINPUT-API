<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';

global $config;

$loop = React\EventLoop\Factory::create();

$handler = function (Psr\Http\Message\ServerRequestInterface $request) use ($loop) {
    
    # ROOT Endpoint
    if ($request->getUri()->getPath() === '/api/1.0') {
        
        $endpoint = new \goINPUT\CAP\Endpoints\RootEndpoint($request);
        return $endpoint->sendResponse();
        
    }
    
    # Users Endpoint
    if ($request->getUri()->getPath() === '/api/1.0/users') {
        
        $endpoint = new \goINPUT\CAP\Endpoints\UsersEndpoint($request);
        return $endpoint->sendResponse();
        
    }
    
    

    if ($request->getUri()->getPath() === '/api/1.0/live') {
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

$server = new React\Socket\Server($config['externalIP'] . ':' . $config['externalPort'], $loop);
$http->listen($server);

$loop->run();
