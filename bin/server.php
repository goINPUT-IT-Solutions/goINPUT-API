<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

global $config;

$loop = React\EventLoop\Factory::create();

$handler = function (Psr\Http\Message\ServerRequestInterface $request) use ($loop) {
    global $config;
    
    if ($config['logs']['accessLogs'] == true) {
        $msgLog = date('Y-m-d H:i:s') . ' ' . $request->getMethod() . ' ' . $request->getUri() . PHP_EOL;
        
        echo $msgLog;
        
        if ($config['logs']['logToFile'] == true) {
            if (!file_exists(BASEDIR . '/logs'))
                mkdir(BASEDIR . "/logs");
            
            file_put_contents(BASEDIR . "/logs/access.log", $msgLog, FILE_APPEND);
        }
    }
    
    $tmpArray = explode("/", $request->getUri()->getPath());
    if ($tmpArray[1] == 'api') {
        
        if ($tmpArray[2] == '1.0') {
            if (!empty($tmpArray[3])) {
                $className = "\\goINPUT\\CAP\\Endpoints\\v1_0\\" . $tmpArray[3] . "Endpoint";
                
                if (class_exists($className)) {
                    $newClass = new $className($request);
                    return $newClass->sendResponse();
                }
                return (new \goINPUT\CAP\Endpoints\v1_0\UndefinedEndpoint($request))->sendResponse();
            }
            return (new \goINPUT\CAP\Endpoints\v1_0\RootEndpoint($request))->sendResponse();
        } elseif (empty($tmpArray[2]) && sizeof($tmpArray) <= 3) {
            return (new \goINPUT\CAP\Endpoints\APIListEndpoint($request))->sendResponse();
        }
        
    } else {
        return new React\Http\Response(
            302,
            [
                'Location' => 'https://goinput-it-solutions.github.io/CustomerAdministrationPanel/'
            ]
        );
    }
    
    return (new \goINPUT\CAP\Endpoints\UndefinedAPIEndpoint($request))->sendResponse();
};

$http = new React\Http\Server($handler);

$server = new React\Socket\Server($config['externalIP'] . ':' . $config['externalPort'], $loop);
$http->listen($server);

// ---------------------------------------------------------------- \\
// ---------------------------------------------------------------- \\

echo "goINPUT API-Server „" . $config["serverName"] . "“ v" . $config["serverVersion"] . PHP_EOL;
echo "Listening on " . str_replace('tcp:', 'http:', $server->getAddress()) . PHP_EOL;
echo "----------------------------------------------------------------" . PHP_EOL;
$loop->run();
