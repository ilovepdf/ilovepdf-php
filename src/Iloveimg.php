<?php

namespace Ilovepdf;

use Ilovepdf\Exceptions\DownloadException;
use Ilovepdf\Exceptions\ProcessException;
use Ilovepdf\Exceptions\TaskException;
use Ilovepdf\Exceptions\UploadException;
use Ilovepdf\Exceptions\StartException;
use Ilovepdf\Exceptions\AuthException;
use Ilovepdf\IlovepdfTool;

/**
 * Class Iloveimg
 *
 * @package Ilovepdf
 */
class Iloveimg extends Ilovepdf
{
    // @var string The base URL for the Iloveimg API.
    private static $startServer = 'https://api.iloveimg.com';
}
