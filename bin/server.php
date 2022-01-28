<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';

global $config;

$loop = React\EventLoop\Factory::create();

$handler = function (Psr\Http\Message\ServerRequestInterface $request) use ($loop) {
    global $config;
    
    $tmpArray = explode("/", $request->getUri()->getPath());
    if($tmpArray[1] == 'api') {
        if ($tmpArray[2] == '1.0') {
            if(!empty($tmpArray[3])) {
                $className = "\\goINPUT\\CAP\\Endpoints\\v1_0\\" . $tmpArray[3] . "Endpoint";
                
                if(class_exists($className)) {
                    $newClass = new $className($request);
                    return $newClass->sendResponse();
                }
                return (new \goINPUT\CAP\Endpoints\v1_0\UndefinedEndpoint($request))->sendResponse();
            }
            return (new \goINPUT\CAP\Endpoints\v1_0\RootEndpoint($request))->sendResponse();
        } elseif (empty($tmpArray[3]))
            return (new \goINPUT\CAP\Endpoints\APIListEndpoint($request))->sendResponse();
    } else {
        return new React\Http\Response(
            302,
            [
                'Location' => 'https://goinput-it-solutions.github.io/CustomerAdministrationPanel/'
            ]
        );
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
                'Access-Control-Allow-Headers' => '*',
            ],
            $stream
        );
    }
    
    return (new \goINPUT\CAP\Endpoints\UndefinedAPIEndpoint($request))->sendResponse();
};

$http = new React\Http\Server($handler);

$server = new React\Socket\Server($config['externalIP'] . ':' . $config['externalPort'], $loop);
$http->listen($server);

$loop->run();
