<?php
require_once("autoload.php");

set_error_handler(function($errno, $errstr, $errfile, $errline) {

    if (!(error_reporting() & $errno)) {
        return;
    }

    throw new Exception("$errstr at $errfile line $errline\n");
});

$_jade = new \Jade\Jade(true);
if (!isset($argv[1])) {
    throw new Exception("File with sources and targets list should be passed");
}

if (!is_file($argv[1]) || !is_readable($argv[1])) {
    throw new Exception("Sources and targets list is not a file or unreadable");
}

$lines = file($argv[1]);
$lineCounter = 1;
foreach ($lines as $line) {
    $a = explode('::', $line);
    if (count($a) !== 2) {
        throw new Exception(
            "Line $lineCounter has invalid format. Source path and target path should be separated by double colon"
        );
    }

    $sourcePath = trim($a[0]);
    if (!$sourcePath) {
        throw new Exception(
            "Line $lineCounter has invalid format. Source path is empty"
        );
    }

    $sourcePath = trim($a[0]);
    if (!is_file($sourcePath) || !is_readable($sourcePath)) {
        throw new Exception(
            "Line $lineCounter. Source path is not a file or unreadable"
        );
    }

    $targetPath = trim($a[1]);
    if (!$sourcePath) {
        throw new Exception(
            "Line $lineCounter has invalid format. Target path is empty"
        );
    }

    if (!is_dir(dirname($targetPath))) {
        if (!mkdir(dirname($targetPath), 0755, true)) {
            throw new Exception(
                "Line $lineCounter. Cant create directory fro target path $targetPath"
            );
        }
    }

    try
    {
        $result = $_jade->render($sourcePath);
        file_put_contents($targetPath, $result);
    } catch (\Exception $e) {
        $message = "Line $lineCounter.\n" . $e->getMessage();
        throw new Exception($message, $e->getCode(), $e);
    }

    $lineCounter++;
}
