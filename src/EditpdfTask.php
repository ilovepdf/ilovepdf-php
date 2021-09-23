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
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool='editpdf';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    /**
     * adds a editpdf element
     *
     * @param $element
     * @return $this
     */
    public function addElement(Element $element)
    {
      $this->elements[] = $element;
      return $this;
    }

    public function getElements()
    {
      return $this->elements;
    }

    public function getElementsData(){
      return array_map(function($elem){ return $elem->__toArray(); }, $this->elements); 
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
