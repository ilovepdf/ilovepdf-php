<?php

namespace Ilovepdf;
/**
 * Class Ilovepdf
 *
 * @package Ilovepdf
 */
class HtmlpdfTask extends Task
{
    /**
     * Viewer width
     * @var integer
     */
    public $view_width = 1920;

    /**
     * Viewer height
     * @var integer|null
     */
    public $view_height;

    /**
     * Time to waith for page response
     *  - default is 10
     *
     * @var integer
     */
    public $navigation_timeout = 10;

    /**
     * Time to wait for javscript execution in page
     * - value  must be between 0 and 5
     * - default is 2
     *
     * @var integer
     */
    public $delay = 2;

    /**
     * @var string|null
     */
    public $page_size;

    /**
     * @var string[]
     */
    private $pageSizeValues = ['A3', 'A4', 'A5', 'A6', 'Letter', 'Auto'];

    /**
     * @var string|null
     */
    public $page_orientation;

    /**
     * @var string[]
     */
    private $pageOrientationyValues = ['portrait', 'landscape'];

    /**
     * Pixels for page margin
     * @var integer
     */
    public $page_margin = 0;

    /**
     * Remove z-index (high value) based elements
     *
     * @var bool|null
     */
    public $remove_popups;

    /**
     * @var bool|null
     */
    public $single_page;

    /**
     * AddnumbersTask constructor.
     *
     * @param null|string $publicKey Your public key
     * @param null|string $secretKey Your secret key
     * @param bool $makeStart Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'htmlpdf';
        parent::__construct($publicKey, $secretKey, $makeStart);

        return true;
    }

    /**
     * @param int $view_width
     * @return HtmlpdfTask
     */
    public function setViewWidth(int $view_width): self
    {
        $this->view_width = $view_width;
        return $this;
    }

    /**
     * @param int $view_height
     * @return HtmlpdfTask
     */
    public function setViewHeight(int $view_height): self
    {
        $this->view_height = $view_height;
        return $this;
    }

    /**
     * @param int $navigation_timeout
     * @return HtmlpdfTask
     */
    public function setNavigationTimeout(int $navigation_timeout): self
    {
        if ($navigation_timeout < 0 || $navigation_timeout > 20) {
            throw new \InvalidArgumentException('Delay must be under 5 seconds');
        }
        $this->navigation_timeout = $navigation_timeout;
        return $this;
    }

    /**
     * @param int $delay
     * @return HtmlpdfTask
     */
    public function setDelay(int $delay): HtmlpdfTask
    {
        if ($delay < 0 || $delay > 5) {
            new \InvalidArgumentException('Delay must be under 5 seconds');
        }
        $this->delay = $delay;
        return $this;
    }

    /**
     * @param string $page_size
     * @return HtmlpdfTask
     */
    public function setPageSize(string $page_size): HtmlpdfTask
    {
        $this->checkValues($page_size, $this->pageSizeValues);
        $this->page_size = $page_size;
        return $this;
    }

    /**
     * @param string $page_orientation
     * @return HtmlpdfTask
     */
    public function setPageOrientation(string $page_orientation): HtmlpdfTask
    {
        $this->checkValues($page_orientation, $this->pageOrientationyValues);

        $this->page_orientation = $page_orientation;
        return $this;
    }

    /**
     * @param int $page_margin
     * @return HtmlpdfTask
     */
    public function setPageMargin(int $page_margin): HtmlpdfTask
    {
        $this->page_margin = $page_margin;
        return $this;
    }

    /**
     * @param bool $remove_popups
     * @return HtmlpdfTask
     */
    public function setRemovePopups(bool $remove_popups): HtmlpdfTask
    {
        $this->remove_popups = $remove_popups;
        return $this;
    }

    /**
     * @param bool $single_page
     * @return HtmlpdfTask
     */
    public function setSinglePage(bool $single_page): HtmlpdfTask
    {
        $this->single_page = $single_page;
        return $this;
    }

    /**
     * Add an url to process.
     *
     * @param string $url
     * @return File|mixed
     */
    public function addUrl($url)
    {
        return $this->addFileFromUrl($url);
    }
}
