<?php

namespace goINPUT\CAP\endpoints;

use Psr\Http\Message\ServerRequestInterface;

class UndefinedEndpoint extends Endpoint
{
    public function __construct(ServerRequestInterface $request)
    {
        global $config;
        
        parent::__construct($request);
        
        $json = json_encode(array(
            "API" => array(
                "Version" => $config['apiVersion'],
                "Copyright" => "Copyright © 2019 - 2022 Schneider, Benjamin & Wolfhard, Elias GbR"
            ),
            "Error" => 'Endpoint is not defined.'
            
        ));
        
        $this->setStatusCode(404);
        $this->appendResponseData(array("Error" => "Endpoint is not defined."));
    }
}