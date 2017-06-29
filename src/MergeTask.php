<?php

namespace Ilovepdf;
/**
 * Class MergeTask
 *
 * @package Ilovepdf
 */
class MergeTask extends Task
{

    /**
     * MergeTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool='merge';
        parent::__construct($publicKey, $secretKey, true);
    }

    /**
     * @param null $processData
     * @return mixed
     */
    public function execute($processData=null){
        return parent::execute(get_object_vars($this));
    }


}
