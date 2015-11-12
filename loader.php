<?php
/* **********************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Matthias Toscanelli <m.toscanelli@code-source.ch>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 * ******************************************************************** */

// Register class loader
require_once('Classes/Core/ClassLoader.php');
spl_autoload_register(array(\CDSRC\PhpBenchmark\Core\ClassLoader::getInstance(), 'load'));

// Default values
$iterations = 1000000;

// Load output renderer
if (strtolower(php_sapi_name()) === "cli") {
    $output = new \CDSRC\PhpBenchmark\Output\CliOutput();
    $iterations = isset($argv[1]) ? (int)$argv[1] : $iterations;
} else {
    $output = new \CDSRC\PhpBenchmark\Output\HtmlOutput();
    $iterations = isset($_GET['iterations']) ? (int)$_GET['iterations'] : $iterations;
}

// Run tests
$handler = opendir(__DIR__ . '/Classes/Tests');
$output->open();
while (($file = readdir($handler)) !== false) {
    if (substr($file, -8) === 'Test.php') {
        $className = 'CDSRC\\PhpBenchmark\\Tests\\' . substr($file, 0, -4);
        $test = new $className($iterations);
        $output->render($test->run());
    }
}
$output->close();