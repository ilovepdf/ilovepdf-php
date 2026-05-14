<?php

namespace Ilovepdf;

use Ilovepdf\Exceptions\InvalidParamsException;

/**
 * Class PDFExtractTask
 *
 *
 * @package Ilovepdf
 */
class PdfExtractTask extends Task
{


    /**
     * @var null Category
     */
    public $category = "invoice";

    private $categoryValues = [
        "invoice",
        "paysheet",
        "check",
        "receipt",
        "receipt.retailMeal",
        "receipt.creditCard",
        "receipt.gas",
        "receipt.parking",
        "receipt.hotel",
        "id",
        "passport",
        "nationalid",
        "residence",
        "ss",
        "driver-license",
        "cv",
        "businesscard",
        "medical-lab-test",
        "medical-reports",
        "medical-vaccination",
        "medical-insurance",
        "medical-prescriptions",
        "medical-insurance-claims",
        "custom"
    ];

    public $export_to = 'json';

    private $exportToValues = ["json", "xlsx", "csv", "xml"];

    public $items = [];

    /**
     * CompressTask constructor.
     *
     * @param null|string $publicKey Your public key
     * @param null|string $secretKey Your secret key
     * @param bool $makeStart Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'pdfextract';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    /**
     * @param string $category
     *
     * @return $this
     */
    function setCategory(string $category): self
    {
        $this->checkValues($category, $this->categoryValues);
        $this->category = $category;
        return $this;
    }

    function addItem(string $itemName, string $itemDescription): self
    {
        $this->items[] = [
            "name" => $itemName,
            "description" => $itemDescription
        ];

        return $this;
    }

    #[\Override]
    public function validate(): void
    {
        if($this->category=='custom' & count($this->items)==0){
            throw new InvalidParamsException('Custom mode requires at least one item');
        }
    }
}
