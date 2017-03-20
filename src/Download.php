<?php

namespace Ilovepdf;

use Yii;

/**
 * Class Download
 *
 * @todo Add params as needed, beacuse we don't want this class extends Task
 *
 * @package Ilovepdf
 */
class Download extends Task
{

    /**
     * Download constructor.
     *
     * @param string $tool The Ilovepdf public API key to be used for requests.
     */
    function __construct($tool = null)
    {
        return true;
    }

    /**
     * @param string $task
     * @param string $path
     *
     * @throws Exceptions\AuthException
     * @throws Exceptions\ProcessException
     * @throws Exceptions\UploadException
     */
    public function downloadFile($task, $path = null)
    {
        $response = parent::sendRequest('get', 'download/' . $task, null);
        preg_match('/ .*filename=\"([\W\w]+)\"/', $response->headers['Content-Disposition'], $matches);

        $filename = str_replace('"', '', $matches[1]);
        if (is_null($path)) $path = '.';
        $destination = $path . '/' . $filename;
        $file = fopen($destination, "w+");
        fputs($file, $response->raw_body);
        fclose($file);
    }

    /**
     * @param $filename string
     * @param $filenameNew string
     *
     * @return string
     */
    private function setFilename($filename, $filenameNew){
        if($filenameNew === null) {
            return $filename;
        }

        $fileInfo = pathinfo($filename);
        $fileInfoNew = pathinfo($filenameNew);

        if($fileInfo['extension']!=$fileInfoNew['extension']){
            var_dump($fileInfo);
            var_dump($fileInfoNew);
            throw new \InvalidArgumentException('Invalid file extension');
        }
        return $filenameNew;
    }

}
