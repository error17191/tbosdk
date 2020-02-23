<?php

namespace TBO\Support;


class XML
{
    protected $xmlDoc;
    protected $xPath;
    protected $xmlTemplate;

    public function __construct($xmlTemplate)
    {
        $this->xmlTemplate = $xmlTemplate;
        $this->xmlDoc = new \DOMDocument();
        $this->xmlDoc->loadXML($this->xmlTemplate);
        $this->xPath = new \DOMXPath($this->xmlDoc);
    }

    public function getElementById($id)
    {
        return $this->xPath->query("//*[@id='$id']")->item(0);
    }

    public function setById( $id ,  $textContent, $keepId = false)
    {
        $dom = $this->getElementById($id);
        $dom->textContent = $textContent;
        if (!$keepId) {
            $dom->removeAttribute('id');
        }
    }

    public function removeElement( $element)
    {
        $parent = $element->parentNode;
        $parent->removeChild($element);
    }

    public function createCloneElementById( $id,  $keepId = false,  $keepElement = false)
    {
        $element = $this->getElementById($id);
        if (!$keepId) {
            $element->removeAttribute('id');
        }
        /** @var \DOMElement $cloneElement */
        $cloneElement = $element->cloneNode();
        if (!$keepElement) {
            $this->removeElement($element);
        }
        return $cloneElement;
    }


    public function removeElementById( $id)
    {
        $element = $this->getElementById($id);
        $this->removeElement($element);
    }


    public function setElementAttributesById( $attributes,  $id,  $keepId = false)
    {
        $element = $this->getElementById($id);
        $this->setElementAttributes($attributes, $element, $keepId);
    }


    public function setElementAttributes( $attributes,  $element,  $keepId = false)
    {
        foreach ($attributes as $attribute => $value) {
            if (is_bool($value)) {
                $value = $value ? "true" : "false";
            }
            $element->setAttribute($attribute, $value);
        }
        if (!$keepId) {
            $element->removeAttribute('id');
        }
    }

    public function createElement( $name,  $value = null,  $nameSpace = 'hot:')
    {
        return $this->xmlDoc->createElement($nameSpace . $name, $value);
    }

    public function getDomXml()
    {
        return $this->xmlDoc;
    }

    public function getXML()
    {
        $this->xmlDoc->preserveWhiteSpace = false;
        $this->xmlDoc->formatOutput = true;
        return $this->xmlDoc->saveXML();
    }
}