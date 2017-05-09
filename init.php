<?php

//Ilovepdf
require_once dirname(__FILE__) . '/src/Ilovepdf.php';
require_once dirname(__FILE__) . '/src/Task.php';


//Specific processes
require_once dirname(__FILE__) . '/src/CompressTask.php';
require_once dirname(__FILE__) . '/src/ImagepdfTask.php';
require_once dirname(__FILE__) . '/src/MergeTask.php';
require_once dirname(__FILE__) . '/src/OfficepdfTask.php';
require_once dirname(__FILE__) . '/src/PagenumberTask.php';
require_once dirname(__FILE__) . '/src/PdfaTask.php';
require_once dirname(__FILE__) . '/src/PdfjpgTask.php';
require_once dirname(__FILE__) . '/src/ProtectTask.php';
require_once dirname(__FILE__) . '/src/RepairTask.php';
require_once dirname(__FILE__) . '/src/RotateTask.php';
require_once dirname(__FILE__) . '/src/SplitTask.php';
require_once dirname(__FILE__) . '/src/UnlockTask.php';
require_once dirname(__FILE__) . '/src/WatermarkTask.php';


//Helpers
require_once dirname(__FILE__) . '/src/JWT.php';
require_once dirname(__FILE__) . '/src/File.php';
require_once dirname(__FILE__) . '/src/Method.php';
require_once dirname(__FILE__) . '/src/Response.php';
require_once dirname(__FILE__) . '/src/Request.php';
require_once dirname(__FILE__) . '/src/Request/Body.php';


//Exceptions
require_once dirname(__FILE__) . '/src/Exceptions/ExtendedException.php';
require_once dirname(__FILE__) . '/src/Exceptions/DownloadException.php';
require_once dirname(__FILE__) . '/src/Exceptions/ProcessException.php';
require_once dirname(__FILE__) . '/src/Exceptions/UploadException.php';
require_once dirname(__FILE__) . '/src/Exceptions/StartException.php';
require_once dirname(__FILE__) . '/src/Exceptions/AuthException.php';