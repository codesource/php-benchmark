<?php

namespace CDSRC\PhpBenchmark\Output;


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

use CDSRC\PhpBenchmark\Core\AbstractTest;

class CliOutput extends AbstractOutput
{
    /**
     * Render a test as HTML
     *
     * @param \CDSRC\PhpBenchmark\Core\AbstractTest $test
     *
     * @return void
     */
    public function render(AbstractTest $test)
    {
        $content = $test->getName() . ' (' . number_format($test->getIterations()) . ' iterations)' . "\n";
        if ($test->getDescription() !== '') {
            $content .= $test->getDescription() . "\n";
        }
        $data = $test->getData();
        if (empty($data) || !is_array($data['header']) || !is_array($data['rows'])) {
            $content .= str_repeat('=', 60) . "\n!!! Test has no data\n";
        } else {
            $lengths = array();
            $headersCount = count($data['header']);
            for ($i = 0; $i < $headersCount; $i++) {
                $lengths[$i] = strlen($data['header'][$i]);
            }
            for ($i = 0, $ni = count($data['rows']); $i < $ni; $i++) {
                if (is_array($data['rows'][$i])) {
                    for ($j = 0; $j < $headersCount; $j++) {
                        if (isset($data['rows'][$i][$j])) {
                            $lengths[$j] = max($lengths[$j], strlen($data['rows'][$i][$j]));
                        }
                    }
                }
            }
            $finalLength = array_sum($lengths) + ($headersCount * 4) - 1;
            $rowSeparator = "\n" . str_repeat('-', $finalLength) . "\n";
            $sectionSeparator = "\n" . str_repeat('=', $finalLength) . "\n";
            $content = $sectionSeparator . $content . str_repeat('=', $finalLength) . "\n";
            $cellSeparator = '';
            for ($i = 0; $i < $headersCount; $i++) {
                $content .= $cellSeparator . ' ' . str_pad($data['header'][$i], $lengths[$i], ' ', STR_PAD_RIGHT) . '  ';
                $cellSeparator = '|';
            }
            $content .= $sectionSeparator;
            for ($i = 0, $ni = count($data['rows']); $i < $ni; $i++) {
                if (is_array($data['rows'][$i])) {
                    $cellSeparator = '';
                    if (!isset($data['rows'][$i][1])) {
                        $content .= ' ' . $data['rows'][$i][0];
                        $content .= $sectionSeparator;
                    } else {
                        for ($j = 0; $j < $headersCount; $j++) {
                            $content .= $cellSeparator . ' ' . str_pad($data['rows'][$i][$j], $lengths[$j], ' ', STR_PAD_RIGHT) . '  ';
                            $cellSeparator = '|';
                        }
                        $content .= $rowSeparator;
                    }
                }
            }
        }
        echo $content . "\n";
    }


}