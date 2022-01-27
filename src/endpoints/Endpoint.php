<?php

namespace goINPUT\CAP\Endpoints;

use Psr\Http\Message\ServerRequestInterface;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../config.php';

class Endpoint
{
    private ServerRequestInterface $__request;
    private string $__responseData = "";
    
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
     * @param string $_responseData
     */
    public function extendResponseData(string $_responseData): void
    {
        $this->__responseData .= $_responseData;
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
        $this->setRequest($request);
    }
    
    public function sendResponse() :\React\Http\Response {
        return new \React\Http\Response(
            200,
            [
                'Content-Type' => 'application/json'
            ],
            $this->getResponseData()
        );
    }
}