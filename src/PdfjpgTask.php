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
     * @var string
     */
    public $pdfjpg_mode;


    /**
     * @var integer
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
     * @return PdfjpgTask
     */
    public function setMode($mode)
    {
        if($mode!="pages" && $mode!="extract"){
            throw new \InvalidArgumentException();
        }
        $this->pdfjpg_mode = $mode;

        return $this;
    }

    /**
     * Set image quality for output
     *
     * @param int $dpi
     * @return PdfjpgTask
     */
    public function setDpi($dpi)
    {
        if($dpi<24 || $dpi>500){
            throw new \InvalidArgumentException('Invalid dpi value');
        }
        $this->dpi = $dpi;
        return $this;
    }
}
