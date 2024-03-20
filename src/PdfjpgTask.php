<?php

namespace Ilovepdf;
/**
 * Class PdfjpgTask
 *
 * @package Ilovepdf
 */
class PdfjpgTask extends Task
{
    /**
     * @var string|null
     */
    public $pdfjpg_mode;


    /**
     * @var string|null
     */
    public $pages;
    
    /**
     * @var integer|null
     */
    public $dpi;

    /**
     * PdfjpgTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'pdfjpg';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    /**
     * Set the process mode: convert each page to image or extract all images in pdf
     *
     * @param string $mode values:["pages"|"extract"] default: "pages"
     * @return $this
     */
    public function setMode($mode): self
    {
        if($mode!="pages" && $mode!="extract"){
            throw new \InvalidArgumentException();
        }
        $this->pdfjpg_mode = $mode;

        return $this;
    }

    /**
     * Set pages for extract pages
     *
     * @param string $mode values:["1-5, 7,12"] default: null
     * @return $this
     */
    public function setPages($pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * Set image quality for output
     *
     * @param int $dpi
     * @return $this
     */
    public function setDpi(int $dpi): self
    {
        if($dpi<24 || $dpi>500){
            throw new \InvalidArgumentException('Invalid dpi value');
        }
        $this->dpi = $dpi;
        return $this;
    }
}
