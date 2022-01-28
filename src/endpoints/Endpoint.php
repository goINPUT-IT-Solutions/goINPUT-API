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

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../config.php';

class Endpoint
{
    private ServerRequestInterface $__request;
    private string $__responseData = "";
    
    private int $__statusCode = 200;
    private string $__jsonData = "";
    private string $__responseType = "application/json";
    
    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return $this->__responseType;
    }
    
    /**
     * @param string $_responseType
     */
    public function setResponseType(string $_responseType): void
    {
        $this->__responseType = $_responseType;
    }
    
    /**
     * @return string
     */
    public function getJsonData(): string
    {
        return $this->__jsonData;
    }
    
    /**
     * @param string $_jsonData
     */
    public function setJsonData(string $_jsonData): void
    {
        $this->__jsonData = $_jsonData;
    }
    
    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->__statusCode;
    }
    
    /**
     * @param int $_statusCode
     */
    public function setStatusCode(int $_statusCode): void
    {
        $this->__statusCode = $_statusCode;
    }
    
    /**
     * @return string
     */
    public function getResponseData(): string
    {
        return $this->__responseData;
    }
    
    /**
     * @param string $_responseData
     */
    public function setResponseData(string $_responseData): void
    {
        $this->__responseData = $_responseData;
    }
    
    /**
     * @param array $_responseData
     */
    public function appendResponseData(array $_responseData): void
    {
        $tmpArray = json_decode($this->getJsonData(), true);
        $tmpJson = json_encode(array_merge($tmpArray, $_responseData));
        
        $this->setJsonData($tmpJson);
        $this->setResponseData($this->getJsonData());
    }
    
    /**
     * @return ServerRequestInterface
     */
    public function getRequest() :ServerRequestInterface
    {
        return $this->__request;
    }
    
    /**
     * @param mixed $_request
     * @return void
     */
    public function setRequest(ServerRequestInterface $_request) :void
    {
        $this->__request = $_request;
    }
    
    public function __construct(ServerRequestInterface $request) {
        global $config;
        $this->setRequest($request);
    
        $this->setJsonData(json_encode(array(
            "API" => array(
                "Version" => $config['apiVersion'],
                "Copyright" => "Copyright © 2019 - 2022 Schneider, Benjamin & Wolfhard, Elias GbR"
            )
        )));
    
        $this->setStatusCode(200);
        $this->setResponseData($this->getJsonData());
    }
    
    public function sendResponse() :\React\Http\Response {
        global $config;
        
        return new \React\Http\Response(
            $this->getStatusCode(),
            [
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Origin' => $config['ACAO'],
                'Access-Control-Allow-Headers' => $config['ACAH'],
                'X-Powered-By' => 'goINPUT API v'.$config["apiVersion"],
                'Server' => 'Hayward'
            ],
            $this->getResponseData()
        );
    }
}