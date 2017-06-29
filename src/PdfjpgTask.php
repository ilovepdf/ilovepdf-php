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
     * PdfjpgTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'pdfjpg';
        parent::__construct($publicKey, $secretKey, true);
    }

    /**
     * @param string $mode values:["pages"|"extract"] default: "pages"
     */
    public function setMode($mode)
    {
        if($mode!="pages" && $mode!="extract"){
            throw new \InvalidArgumentException();
        }
        $this->pdfjpg_mode = $mode;
    }
}
