<?php


namespace TBO\Request\Inner;


use TBO\Support\XML;

abstract class InnerRequestBuilder
{
    /**
     * @var \TBO\Support\XML
     */
    protected $xml;

    public function __construct($data,$xml)
    {
        $this->xml = $xml;
        $this->xml->replace($this->initialXML());
        $this->xml->build();
        $this->build($data);
    }

    abstract protected function build($data);

    abstract protected function initialXML();

    protected function setDataToXML(array $data)
    {
        foreach ($data as $key => $value) {
            $this->xml->setById($key,$value);
        }
    }

    protected function removeUnusedKeysInRequest()
    {
        $elements = $this->xml->getElementsByAttribute();
        foreach ($elements as $element) {
            $this->xml->removeElement($element);
        }
    }

    public function xml()
    {
        return $this->xml->getXML();
    }

}