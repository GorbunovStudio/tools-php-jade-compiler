<?php

/**
 * @link http://www.optimuspro.ru/
 * @copyright Copyright (c) 2014 Optimus LLC
 * @license MIT
 */

require_once("autoload.php");

$_jade = new \Jade\Jade(true);
$result = $_jade->render($argv[1]);

file_put_contents($argv[2], $result);
