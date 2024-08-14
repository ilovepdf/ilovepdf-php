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

    public $pdf_pages;

    public $pdf_page_number;

    public $pdf_forms;


    /**
     * File constructor.
     * @param string $server_filename
     * @param string $filename
     */
    function __construct(string $server_filename, string $filename)
    {
        $this->setServerFilename($server_filename);
        $this->setFilename($filename);
    }

    /**
     * @return array
     */
    function getFileOptions(): array
    {
        return [
            'server_filename' => $this->server_filename,
            'filename' => $this->filename,
            'rotate' => $this->rotate,
            'password' => $this->password,
            'pdf_pages' => $this->pdf_pages,
            'pdf_page_number' => $this->pdf_page_number,
            'pdf_forms' => $this->pdf_forms
        ];
    }


    /**
     * @param int $degrees [0|90|180|270]
     * @return File
     */
    function setRotation(int $degrees): self
    {
        if ($degrees != 0 && $degrees != 90 && $degrees != 180 && $degrees != 270) {
            throw new \InvalidArgumentException;
        }
        $this->rotate = $degrees;
        return $this;
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
     * @return array|null
     */
    function getSanitizedPdfPages(): ?array
    {
        if (is_null($this->pdf_pages)) {
            return null;
        }
        return array_map(function ($pdf_page):array {
            list($width, $height) = explode("x", $pdf_page);
            return ["width" => $width, "height" => $height];
        }, $this->pdf_pages);
    }

    function getLastPage(): int
    {
        return $this->pdf_page_number;
    }

    function getPdfPageInfo(int $pageNumber): ?array
    {
        $pdfPages = $this->getSanitizedPdfPages();
        if (is_null($pdfPages)) {
            return null;
        }
        return $pdfPages[$pageNumber - 1];
    }

    function eachPdfFormElement(callable  $callback): void
    {
        if(empty($this->pdf_forms)){
            return;
        }
        foreach ($this->pdf_forms as $pdfFormElement) {
            // Call the callback function for each element, passing the key and val
            $pdfPageInfo = $this->getPdfPageInfo($pdfFormElement['page']);
            $callback($pdfFormElement, $pdfPageInfo);
        }
    }


    /**
     * @param string $server_filename
     * @return File
     */
    function setServerFilename(string $server_filename): self
    {
        if ($server_filename == '') {
            throw new \InvalidArgumentException;
        }
        $this->server_filename = $server_filename;

        return $this;
    }

    /**
     * @param array $formParams
     * @return File
     */
    function setPdfForms(?array $formParams): self
    {
        if (empty($formParams)) {
            throw new \InvalidArgumentException;
        }
        $this->pdf_forms = $formParams;

        return $this;
    }

    /**
     * @param string $filename
     * @return File
     */
    function setFilename(string $filename): self
    {
        if ($filename == '') {
            throw new \InvalidArgumentException;
        }
        $this->filename = $filename;

        return $this;
    }
}
