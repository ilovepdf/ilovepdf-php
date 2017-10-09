<?php

namespace Ilovepdf;
/**
 * Class CompressimageTask
 *
 * @package Ilovepdf
 */
class ResizeimageTask extends Task
{
    /**
     * @var string
     */
    public $resize_mode = 'pixels';

    /**
     * @var bool
     */
    public $maintain_ratio = true;

    /**
     * @var bool
     */
    public $no_enlarge_if_smaller = true;

    /**
     * @var int
     */
    public $pixels_width = 0;

    /**
     * @var int
     */
    public $pixels_height = 0;

    /**
     * @var int
     */
    public $percentage = null;

    /**
     * @var array
     */
    private $resizeModeValues = ["percentage", "pixels"];

    /**
     * CompressTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'resizeimage';
        parent::__construct($publicKey, $secretKey, true);
    }

    /**
     * @param $level string
     *
     * values: ["percentage"|"pixels"]
     * default: "percentage"
     * @return $this
     */
    public function setResizeMode($mode)
    {
        $this->checkValues($mode, $this->resizeModeValues);

        $this->resize_mode = $mode;

        return $this;
    }

    /**
     * @param boolean $maintain_ratio
     * @return $this
     */
    public function setMaintainRatio($maintain_ratio)
    {
        $this->maintain_ratio = $maintain_ratio;
        return $this;
    }

    /**
     * @param boolean $no_enlarge_if_smaller
     * @return ResizeimageTask
     */
    public function setNoEnlargeIfSmaller($no_enlarge_if_smaller)
    {
        $this->no_enlarge_if_smaller = $no_enlarge_if_smaller;
        return $this;
    }

    /**
     * @param int $pixels_width
     * @return ResizeimageTask
     */
    public function setPixelsWidth($pixels_width)
    {
        $this->pixels_width = $pixels_width;
        return $this;
    }

    /**
     * @param int $pixels_height
     * @return ResizeimageTask
     */
    public function setPixelsHeight($pixels_height)
    {
        $this->pixels_height = $pixels_height;
        return $this;
    }

    /**
     * @param int $percentage
     * @return ResizeimageTask
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }
}
