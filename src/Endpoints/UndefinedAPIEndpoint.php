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

require_once __DIR__ . '/../../config.php';

use Psr\Http\Message\ServerRequestInterface;

class UndefinedAPIEndpoint extends BasicEndpoint
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
            "Error" => 'API Version is not defined.'
        
        ));
        
        $this->setStatusCode(404);
        $this->appendResponseData(array("Error" => "API Version is not defined."));
    }
}