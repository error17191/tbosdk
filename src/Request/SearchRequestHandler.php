<?php


namespace TBO\Request;


use TBO\Response\SearchResponseHandler;

class SearchRequestHandler extends RequestHandler
{

    // returns the request body xml
    protected function buildRequestBody($data)
    {
        // TODO: Implement buildRequestBody() method.
    }


    protected function responseHandler()
    {
        return new SearchResponseHandler();
    }

    protected function action()
    {
        return "HotelSearch";
    }
}