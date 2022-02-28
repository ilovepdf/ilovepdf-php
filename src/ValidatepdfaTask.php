<?php

namespace Ilovepdf;
use Ilovepdf\Exceptions\DownloadException;

/**
 * Class ValidatepdfaTask
 *
 * @package Ilovepdf
 */
class ValidatepdfaTask extends Task
{
    /**
     * @var string
     */
    public $conformance = "pdfa-2b";

    /**
     * @var string[]
     */
    private $conformanceValues = ['pdfa-1b', 'pdfa-1a', 'pdfa-2b', 'pdfa-2u', 'pdfa-2a', 'pdfa-3b', 'pdfa-3u', 'pdfa-3a'];

    /**
     * CompressTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'validatepdfa';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    /**
     * @param string $conformance
     * @return Task
     */
    public function setConformance($conformance)
    {
        $this->checkValues($conformance, $this->conformanceValues);

        $this->conformance = $conformance;
        return $this;
    }

    /**
     * @param string|null $path
     * @return void
     * @throws DownloadException
     */
    public function download($path = null)
    {
        throw new DownloadException('This task have no files to download');
    }

    public function blob(){
        throw new DownloadException('This task have no files to download');
    }

    public function toBrowser(){
        throw new DownloadException('This task have no files to download');
    }
}
