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
     * @var string|null
     */
    public $server_filename;

    /**
     * @var string|null
     */
    public $filename;

    /**
     * @var int|null
     */
    public $rotate;

    /**
     * @var string|null
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
        return [
            'server_filename' => $this->server_filename,
            'filename' => $this->filename,
            'rotate' => $this->rotate,
            'password' => $this->password
        ];
    }


    /**
     * @param integer $degrees [0|90|180|270]
     * @return File
     */
    function setRotation($degrees): self
    {
        if($degrees!=0 && $degrees!=90 && $degrees!=180 && $degrees!=270){
            throw new \InvalidArgumentException;
        }
        $this->rotate = $degrees;
        return $this;
    }

    /**
     * @param string $password
     * @return File
     */
    function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    function getServerFilename(): ?string
    {
        return $this->server_filename;
    }

    /**
     * @param string $server_filename
     * @return File
     */
    function setServerFilename(string $server_filename): self
    {
        if($server_filename == '') {
            throw new \InvalidArgumentException;
        }
        $this->server_filename = $server_filename;

        return $this;
    }

    /**
     * @param string $filename
     * @return File
     */
    function setFilename(string $filename): self
    {
        if($filename == '') {
            throw new \InvalidArgumentException;
        }
        $this->filename = $filename;

        return $this;
    }
}
