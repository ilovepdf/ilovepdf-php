<?php

//Helpers
require_once __DIR__ . '/src/Lib/JWT.php';
require_once __DIR__ . '/src/File.php';
require_once __DIR__ . '/src/Request/Method.php';
require_once __DIR__ . '/src/Request/Response.php';
require_once __DIR__ . '/src/Request/Request.php';
require_once __DIR__ . '/src/Request/Body.php';

//Exceptions
require_once __DIR__ . '/src/Exceptions/ExtendedException.php';
require_once __DIR__ . '/src/Exceptions/DownloadException.php';
require_once __DIR__ . '/src/Exceptions/ProcessException.php';
require_once __DIR__ . '/src/Exceptions/UploadException.php';
require_once __DIR__ . '/src/Exceptions/StartException.php';
require_once __DIR__ . '/src/Exceptions/AuthException.php';
require_once __DIR__ . '/src/Exceptions/PathException.php';

//Ilovepdf
require_once __DIR__ . '/src/Ilovepdf.php';
require_once __DIR__ . '/src/Task.php';

//Specific processes
require_once __DIR__ . '/src/CompressTask.php';
require_once __DIR__ . '/src/ExtractTask.php';
require_once __DIR__ . '/src/HtmlpdfTask.php';
require_once __DIR__ . '/src/ImagepdfTask.php';
require_once __DIR__ . '/src/MergeTask.php';
require_once __DIR__ . '/src/OfficepdfTask.php';
require_once __DIR__ . '/src/PagenumberTask.php';
require_once __DIR__ . '/src/PdfaTask.php';
require_once __DIR__ . '/src/PdfjpgTask.php';
require_once __DIR__ . '/src/ProtectTask.php';
require_once __DIR__ . '/src/RepairTask.php';
require_once __DIR__ . '/src/RotateTask.php';
require_once __DIR__ . '/src/SplitTask.php';
require_once __DIR__ . '/src/UnlockTask.php';
require_once __DIR__ . '/src/ValidatepdfaTask.php';
require_once __DIR__ . '/src/WatermarkTask.php';
