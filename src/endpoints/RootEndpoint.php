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

namespace goINPUT\CAP\Endpoints;

use Psr\Http\Message\ServerRequestInterface;

class RootEndpoint extends Endpoint
{
    public function __construct(ServerRequestInterface $request)
    {
        global $config;
        
        parent::__construct($request);
    
        $json = json_encode(array(
            "API" => array(
                "Version" => $config['apiVersion'],
            ),
            "Copyright" => "Copyright © 2019 - 2022 Schneider, Benjamin & Wolfhard, Elias GbR"
        ));
        
        $this->setResponseData($json);
    }
}