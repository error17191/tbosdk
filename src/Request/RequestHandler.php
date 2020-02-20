<?php


namespace TBO\Request;


abstract class RequestHandler
{
    protected $credintials;
    protected $mode;

    public function __construct($credintails, $mode)
    {
        $this->credintials = $credintails;
        $this->mode = $mode;
    }

    public function buildRequest($data)
    {

    }

    public function sendRequest()
    {
        // after sending request

    }

    public function getRequestXML()
    {

    }

    public function getRequestDOM()
    {

    }

    // returns xml string to used in buildRequest method
    protected abstract function buildRequestBody($data);

    // to be used in sendRequest
    protected abstract function responseHandler();

    protected abstract function action();
}