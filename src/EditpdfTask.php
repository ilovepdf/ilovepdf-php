<?php

namespace Ilovepdf;

use Ilovepdf\Editpdf\Element;

/**
 * Class EditpdfTask
 *
 * @package Ilovepdf
 */
class EditpdfTask extends Task
{
    /**
     * @var array
     */
    public $elements;


    /**
     * EditpdfTask constructor.
     *
     * @param null|string $publicKey Your public key
     * @param null|string $secretKey Your secret key
     * @param bool $makeStart Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'editpdf';
        $this->elements = [];
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    /**
     * adds a editpdf element
     *
     * @param $element
     * @return $this
     */
    public function addElement(Element $element): self
    {
        $this->elements[] = $element;
        return $this;
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function getElementsData(): array
    {
        return array_map(function ($elem): array {
            return $elem->__toArray();
        }, $this->elements);
    }

    public function __toArray()
    {
        $data = array_merge(
            parent::__toArray(),
            ['elements' => $this->getElementsData()]
        );
        return $data;
    }
}
