<?php

/**
 * @link http://www.optimuspro.ru/
 * @copyright Copyright (c) 2014 Optimus LLC
 * @license MIT
 */

require_once("autoload.php");

$_jade = new \Jade\Jade(true);
$result = $_jade->render($argv[1]);

if (!is_dir(dirname($argv[2]))) {
    if (!mkdir(dirname($argv[2]), 0755, true)) {
        exit(1);
    }
}

file_put_contents($argv[2], $result);
