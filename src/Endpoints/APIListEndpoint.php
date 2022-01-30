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

class APIListEndpoint extends BasicEndpoint
{
    
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function __construct(\Psr\Http\Message\ServerRequestInterface $request)
    {
        parent::__construct($request);
        
        $apis = scandir(BASEDIR . "/src/Endpoints");
        $apiVersions = array_diff($apis, array('.', '..'));
        
        $json['APIs'] = [];
        
        foreach($apiVersions as $api) {
            if( !str_ends_with($api, '.php') ) {
                
                $apiEndpoints = scandir(BASEDIR . "/src/Endpoints/$api");
                $apiEndpoints = array_diff($apiEndpoints, array('.', '..'));
    
                $apiName = str_replace("v", "", $api);
                $apiName = str_replace("_", ".", $apiName);
    
                $json['APIs'][$apiName] = null;
    
                foreach ($apiEndpoints as $apiEndpoint) {
                    if($apiEndpoint == "Endpoint.php")
                        continue;
                    
                    $endpoint = mb_strtolower(mb_substr($apiEndpoint, 0, -12));
                    
                    if($endpoint == "undefined" or
                        $endpoint == "root")
                        continue;
                    
                    $json['APIs'][$apiName][$endpoint] = array(
                        "Endpoint" => "/$endpoint",
                        "Documentation" => "https://docs.goinput.de/api#$endpoint"
                    );
                }
            }
        }
        
        $this->appendResponseData($json);
    }
}