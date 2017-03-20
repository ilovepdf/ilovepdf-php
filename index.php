<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 09/02/2017
 * Time: 19:17
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('init.php');

use Ilovepdf\Ilovepdf;

try {
    //exit();
    $i = 0;
    $ilovepdf = new Ilovepdf();
    $ilovepdf->setApiKeys('public_ilovepdf_DGNsA2g9xcSbpVZrbFBw2ULyRmp6HKse', 'secret_ilovepdf_72TmANGpDyhN4jxjErsaGehsTCzhhyzz');
    $myTask = $ilovepdf->newTask('compress');
    $file = $myTask->addFile('data/sourcefiles/a.pdf');

    //$myTask->setCompressionLevel('guillem');
    $myTask->setOutputFilename('lowlow_compression');
    $myTask->setPackagedFilename('splitted_pdf1');
    $time = $myTask->execute();
    $myTask->download();
    //$myTask->destroy();

} catch (Exceptions\UploadException $e) {
    // echo $e->getCode();
    // echo $e->getType();
    // echo $e->getMessage();
    echo '<pre>' . $e->getType() . ' <br/>';
    if (count($e->getErrors()) > 0) {
        foreach ($e->getErrors() as $field => $error_message) {
            foreach ($error_message as $single_message) {
                echo $field . ': ' . $single_message . '<br/>';
            }
        }
    }
    echo '</pre>';
} catch (Exceptions\ProcessException $e) {
    //echo $e->getCode();
    //echo $e->getType();
    //echo $e->getMessage();
    echo '<pre>' . $e->getType() . ': <br/>';
    var_dump($e->getMessage());
    if (count($e->getErrors()) > 0) {
        foreach ($e->getErrors() as $field => $error_message) {
            foreach ($error_message as $single_message) {
                echo $field . ': ' . $single_message . '<br/>';
            }
        }
    }
    echo '</pre>';
} catch (Exceptions\AuthException $e) {
    echo $e->getMessage();
} catch (Exceptions\Exception $e) {
    echo $e->getMessage();
} catch (\Exception $e) {
    echo $e->getMessage();
}