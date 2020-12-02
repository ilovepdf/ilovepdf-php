<?php

namespace Ilovepdf;
/**
 * Class Ilovepdf
 *
 * @package Ilovepdf
 */
class File
{
    /**
     * @var string
     */
    public $server_filename;

    /**
     * @var string
     */
    public $filename;

    /**
     * @var integer
     */
    public $rotate;

    /**
     * @var string
     */
    public $password;


    /**
     * File constructor.
     * @param string $server_filename
     * @param string $filename
     */
    function __construct($server_filename, $filename)
    {
        $this->setServerFilename($server_filename);
        $this->setFilename($filename);
    }

    /**
     * @return array
     */
    function getFileOptions()
    {
        return array(
            'server_filename' => $this->server_filename,
            'filename' => $this->filename,
            'rotate' => $this->rotate,
            'password' => $this->password
        );
    }


    /**
     * @param integer $degrees [0|90|180|270]
     * @return bool
     */
    function setRotation($degrees)
    {
        if($degrees!=0 && $degrees!=90 && $degrees!=180 && $degrees!=270){
            throw new \InvalidArgumentException;
        }
        $this->rotate = $degrees;
        return true;
    }

    /**
     * @param $password
     * @return bool
     */
    function setPassword($password)
    {
        $this->password = $password;
        return true;
    }

    /**
     * @return string
     */
    function getServerFilename()
    {
        return $this->server_filename;
    }

    function setServerFilename($server_filename)
    {
        if($server_filename == '') {
            throw new \InvalidArgumentException;
        }
        $this->server_filename = $server_filename;
    }


    function setFilename($filename)
    {
        if($filename == '') {
            throw new \InvalidArgumentException;
        }
        $this->filename = $filename;
    }
}
