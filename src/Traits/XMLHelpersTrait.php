<?php


namespace TBO\Traits;


trait XMLHelpersTrait
{
    protected $xmlDoc;
    protected $xPath;

    protected function createXmlParser()
    {
        $this->xmlDoc = new \DOMDocument();
        $this->xmlDoc->loadXML($this->getBasicRequestBody());
        $this->xPath = new \DOMXPath($this->xmlDoc);
    }

    public function getElementById(string $id)
    {
        return $this->xPath->query("//*[@id='$id']")->item(0);
    }
}