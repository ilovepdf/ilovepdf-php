<?php

namespace Ilovepdf;

use stdClass;

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

    public $pdf_pages;

    public $pdf_page_number;


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
    function getFileOptions(): array
    {
        return array(
            'server_filename' => $this->server_filename,
            'filename' => $this->filename,
            'rotate' => $this->rotate,
            'password' => $this->password,
            'pdf_pages' => $this->pdf_pages,
            'pdf_page_number' => $this->pdf_page_number
        );
    }


    /**
     * @param integer $degrees [0|90|180|270]
     * @return bool
     */
    function setRotation($degrees): bool
    {
        if($degrees!=0 && $degrees!=90 && $degrees!=180 && $degrees!=270){
            throw new \InvalidArgumentException;
        }
        $this->rotate = $degrees;
        return true;
    }

    /**
     * @param $pdf_pages
     * @return bool
     */
    function setPdfPages($pdf_pages): bool
    {
        $this->pdf_pages = $pdf_pages;
        return true;
    }

    /**
     * @param $pdf_page_number
     * @return bool
     */
    function setPdfPageNumber(int $pdf_page_number): bool
    {
        $this->pdf_page_number = $pdf_page_number;
        return true;
    }

    /**
     * @param $password
     * @return bool
     */
    function setPassword($password): bool
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

    function getSanitizedPdfPages(): ?array{
        if(is_null($this->pdf_pages)){
            return null;
        }
        array_map(function($pdf_page){
            list($width,$height) = explode("x",$pdf_page);
            return (object)["width" => $width,"height" => $height];
        },$this->pdf_pages);
    }

    function getLastPage(): int{
        return $this->pdf_page_number;
    }

    function getPdfPageInfo(int $pageNumber): ?\stdClass{
        $pdfPages = $this->getSanitizedPdfPages();
        if(is_null($pdfPages)){
            return null;
        }
        return $pdfPages[$pageNumber-1];
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
