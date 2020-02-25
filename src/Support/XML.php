<?php

namespace TBO\Support;


class XML
{
    /**
     * @var \DOMDocument
     */
    protected $xmlDoc;

    /**
     * @var \DOMXPath
     */
    protected $xPath;

    /**
     * @var string
     */
    protected $XMLString;

    /**
     * XML constructor.
     * @param string $XMLString
     */
    public function __construct(string $XMLString)
    {
        $this->XMLString = $XMLString;
    }

    /**
     * build the xml
     */
    public function build()
    {
        $this->xmlDoc = new \DOMDocument();
        $this->xmlDoc->loadXML($this->XMLString);
        $this->xPath = new \DOMXPath($this->xmlDoc);
    }

    /**
     * @param string $XMLReplace
     * @param string $replace
     */
    public function replace(string $XMLReplace,string $replace = 'replace')
    {
        $this->XMLString = str_replace($replace,$XMLReplace,$this->XMLString);
    }

    /**
     * @param string $id
     * @return \DOMNode|null
     */
    public function getElementById(string $id)
    {
        return $this->xPath->query("//*[@id='$id']")->item(0);
    }

    /**
     * @param string $id
     * @param string $textContent
     * @param bool $keepId
     */
    public function setById(string $id,string $textContent,bool $keepId = false)
    {
        $dom = $this->getElementById($id);
        if(!$dom){
            return;
        }
        $dom->textContent = $textContent;
        if (!$keepId) {
            $dom->removeAttribute('id');
        }
    }

    /**
     * @param \DOMNode $element
     */
    public function removeElement(\DOMNode $element)
    {
        $parent = $element->parentNode;
        $parent->removeChild($element);
    }

    /**
     * @param string $id
     * @param bool $keepId
     * @param bool $keepElement
     * @return \DOMElement|void
     */
    public function cloneElementById(string $id, bool  $keepId = false, bool $keepElement = false)
    {
        $element = $this->getElementById($id);
        if(!$element){
            return;
        }
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

    /**
     * @param string $id
     */
    public function removeElementById(string $id)
    {
        $element = $this->getElementById($id);
        if(!$element){
            return;
        }
        $this->removeElement($element);
    }

    /**
     * @param array $attributes
     * @param string $id
     * @param bool $keepId
     */
    public function setElementAttributesById(array $attributes,string  $id,bool $keepId = false)
    {
        $element = $this->getElementById($id);
        if(!$element){
            return;
        }
        $this->setElementAttributes($attributes, $element, $keepId);
    }

    /**
     * @param array $attributes
     * @param \DOMNode $element
     * @param bool $keepId
     */
    public function setElementAttributes(array $attributes,\DOMNode $element,bool $keepId = false)
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

    /**
     * @param string $name
     * @param string|null $value
     * @param string $nameSpace
     * @return \DOMElement
     */
    public function createElement(string $name,string $value = null,string $nameSpace = 'hot:')
    {
        return $this->xmlDoc->createElement($nameSpace . $name, $value);
    }

    /**
     * @return \DOMDocument
     */
    public function getDomXML()
    {
        return $this->xmlDoc;
    }

    /**
     * @return string
     */
    public function getXML()
    {
        $this->xmlDoc->preserveWhiteSpace = false;
        $this->xmlDoc->formatOutput = true;
        return $this->xmlDoc->saveXML();
    }
}