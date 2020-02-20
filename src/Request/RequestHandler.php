<?php


namespace TBO\Request;


abstract class RequestHandler
{
    protected $username;
    protected $password;
    protected $mode;

    public function __construct($username, $password, $mode)
    {
        $this->username = $username;
        $this->password = $password;
        $this->mode = $mode;
    }

    public function buildRequest($data)
    {
        $innerXML = $this->buildRequestBody($data);
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