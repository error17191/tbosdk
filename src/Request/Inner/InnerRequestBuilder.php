<?php


namespace TBO\Request\Inner;


interface InnerRequestBuilder
{
    public function build($data);

    public function xml();
}