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

namespace goINPUT\CAP\Endpoints\v1_0;

require_once __DIR__ . '/../../../config.php';

use Psr\Http\Message\ServerRequestInterface;

class DNSEndpoint extends Endpoint
{
    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct($request);
        
        $this->appendResponseData(array("TestData" => "DNS"));
    }
}