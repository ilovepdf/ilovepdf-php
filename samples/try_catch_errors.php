<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\Ilovepdf;
use Ilovepdf\SplitTask;


try {
    // start the manager classy
    // to get your key pair, please visit https://developer.ilovepdf.com/user/projects
    $ilovepdf = new Ilovepdf('project_public_id','project_secret_key');

    // and get the task tool
    $myTask = $ilovepdf->newTask('split');

    // or you can call task class directly, this set the same tool as before
    $myTask = new SplitTask('project_public_id','project_secret_key');


    // file var keeps info about server file id, name...
    // it can be used latter to cancel file
    $file = $myTask->addFile('/path/to/file/document.pdf');

    // set ranges to split the document
    $myTask->setRanges("2-4,6-8");

    // and set name for output file.
    // in this case it will output a zip file, so we set the package name.
    $myTask->setPackagedFilename('split_documents');

    // and name for splitted document (inside the zip file)
    $myTask->setOutputFilename('split');

    // process files
    $myTask->execute();

    // and finally download file. If no path is set, it will be downloaded on current folder
    $myTask->download('path/to/download');

} catch (\Ilovepdf\Exceptions\StartException $e) {
    echo "An error occured on start: " . $e->getMessage() . " ";
} catch (\Ilovepdf\Exceptions\AuthException $e) {
    echo "An error occured on auth: " . $e->getMessage() . " ";
    echo implode(', ', $e->getErrors());
} catch (\Ilovepdf\Exceptions\UploadException $e) {
    echo "An error occured on upload: " . $e->getMessage() . " ";
    echo implode(', ', $e->getErrors());
} catch (\Ilovepdf\Exceptions\ProcessException $e) {
    echo "An error occured on process: " . $e->getMessage() . " ";
    echo implode(', ', $e->getErrors());
} catch (\Exception $e) {
    echo "An error occured: " . $e->getMessage();
}