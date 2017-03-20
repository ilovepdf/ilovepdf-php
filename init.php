<?php

require_once dirname(__FILE__) . '/src/Exception.php';
require_once dirname(__FILE__) . '/src/Exceptions/Exception.php';
require_once dirname(__FILE__) . '/src/Exceptions/ProcessException.php';
require_once dirname(__FILE__) . '/src/Exceptions/UploadException.php';
require_once dirname(__FILE__) . '/src/Exceptions/AuthException.php';
require_once dirname(__FILE__) . '/src/Exception.php';
require_once dirname(__FILE__) . '/src/JWT.php';

//Ilovepdf

require_once dirname(__FILE__) . '/src/Ilovepdf.php';
require_once dirname(__FILE__) . '/src/Task.php';


//Specific processes
require_once dirname(__FILE__) . '/src/CompressTask.php';
require_once dirname(__FILE__) . '/src/MergeTask.php';
require_once dirname(__FILE__) . '/src/SplitTask.php';
require_once dirname(__FILE__) . '/src/OfficepdfTask.php';

require_once dirname(__FILE__) . '/src/Download.php';
require_once dirname(__FILE__) . '/src/File.php';
require_once dirname(__FILE__) . '/src/Upload.php';
require_once dirname(__FILE__) . '/src/Method.php';
require_once dirname(__FILE__) . '/src/Response.php';
require_once dirname(__FILE__) . '/src/Request.php';
require_once dirname(__FILE__) . '/src/Request/Body.php';
