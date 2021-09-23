<?php

namespace Ilovepdf\Sign;

use Ilovepdf\File;
use Ilovepdf\Sign\Elements\ElementAbstract;

class SignatureFile
{

    /**
     * @var string
     */
    public $file;
    /**
     * @var string
     */
    public $server_filename;

    /**
     * @var array
     */
    public $elements = [];


    public function __construct(File $file, array $elements = [])
    {
        $this->file;
        $this->server_filename = $file->getServerFilename();
        $this->setElements($elements);
    }

    /**
     * @return string
     */
    public function getServerFilename(): string
    {
        return $this->server_filename;
    }

    /**
     * @param string $server_filename
     * @return SignatureFile
     */
    public function setServerFilename(string $server_filename): SignatureFile
    {
        $this->server_filename = $server_filename;
        return $this;
    }


    /**
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * @param array $elements
     */
    public function setElements(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @param array $elements
     */
    public function addElement(ElementAbstract $element)
    {
        $this->elements[] = $element;
    }

    public function getElementsData(): array
    {
        $data = [];
        foreach ($this->getElements() as $element) {
            $data[] = $element->__toArray();
        }
        return $data;
    }

    public function __toArray()
    {
        return [
            'server_filename' => $this->getServerFilename(),
            'elements' => $this->getElementsData()
        ];
    }
}